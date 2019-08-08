import { Component, OnInit } from '@angular/core';
import {ActivatedRoute, Router} from '@angular/router';
import {LoginManagementService} from '../services/login-management.service';
import {Participant} from '../models/Participant';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {MustMatch} from '../helpers/MustMatchValidator';
import {Site} from '../models/Site';
import {SitesManagementService} from '../services/sites-management.service';
import {ParticipantManagementService} from '../services/participant-management.service';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.css']
})
export class ProfileComponent implements OnInit {
  // Pseudo of the profile visited
  pseudoProfile: string;
  // pic of the profile
  picture: any;
  profile: Participant;
  // We will check if the profile visited is the one of the user logged in or not
  isUserLoggedIn: boolean;
  currentUser: Participant;

  // Form values
  profileForm: FormGroup;
  error: string;

  // We need all the sites
  sites: Site[];

  constructor(private route: ActivatedRoute,
              private loginManagement: LoginManagementService,
              private sitesManagement: SitesManagementService,
              private participantManagement: ParticipantManagementService,
              private formBuilder: FormBuilder,
              private router: Router) {
  }

  ngOnInit() {
    // Where are we ?
    this.pseudoProfile = this.route.snapshot.params.pseudo;
    this.participantManagement.getParticipantByPseudo(this.pseudoProfile).subscribe(
      (value) => {
        this.profile = value;
        if (value.urlPicture !== undefined) {
          this.participantManagement.getParticipantPictureByPseudo(this.pseudoProfile).subscribe(
            (picture) => {
              const reader = new FileReader();
              reader.readAsDataURL(picture);
              reader.onloadend = () => {
                this.picture = reader.result;
              };
            }
          );
        }
      },
      (error) => {
        if (error.status === 404) {
          this.router.navigate(['/home']);
        }
      }
    );
    // Who are we ?
    this.loginManagement.isUserLoggedIn.subscribe(
      value => { this.isUserLoggedIn = value; }
    );
    this.loginManagement.currentUser.subscribe(
      value => {
        this.currentUser = new Participant();
        this.currentUser = value;
        if (this.currentUser !== null) {
          this.createForm();
        }
      }
    );
    // Where do we come from ?
    this.sitesManagement.getSites().subscribe(
      (response) => {
        this.sites = response;
      },
      (error) => {
        this.error = error.status;
        console.log('Error : ' + error.status + ':' + error.message);
      }
    );
  }

  private createForm() {
    this.profileForm = this.formBuilder.group({
      pseudo: [this.currentUser.pseudo, Validators.required],
      firstName: [this.currentUser.firstName, Validators.required],
      lastName: [this.currentUser.lastName, Validators.required],
      phone: this.currentUser.phone == null ? '' : this.currentUser.phone,
      mail: [this.currentUser.mail, [Validators.required, Validators.email]],
      password: '',
      confirmPassword: '',
      site: ''
    }, {
      // custom validator
      validators: MustMatch('password', 'confirmPassword')
    });
  }

  private invalidField(field: string) {
    return this.profileForm.controls[field].invalid &&
      (this.profileForm.controls[field].dirty ||
        this.profileForm.controls[field].touched);
  }

  issueValidation() {
    return this.profileForm.pristine || this.profileForm.invalid;
  }

  onSubmitForm() {
    const formValue = this.profileForm.value;
    if (!this.issueValidation()) {
      const updatedUser = Object.assign({}, this.currentUser);
      if (this.currentUser.pseudo !== formValue.pseudo) {
        updatedUser.pseudo = formValue.pseudo;
      }
      if (this.currentUser.lastName !== formValue.lastName) {
        updatedUser.lastName = formValue.lastName;
      }
      if (this.currentUser.firstName !== formValue.firstName) {
        updatedUser.firstName = formValue.firstName;
      }
      if (this.currentUser.phone !== formValue.phone) {
        updatedUser.phone = formValue.phone;
      }
      if (this.currentUser.mail !== formValue.mail) {
        updatedUser.mail = formValue.mail;
      }
      if (formValue.site.length > 0) {
        // tslint:disable-next-line:triple-equals
        updatedUser.site = this.sites.find(site => site.nbSite == formValue.site);
      }
      if (formValue.password.length > 0) {
        updatedUser.password = formValue.password;
      } else {
        updatedUser.password = null;
      }
      this.participantManagement.putUpdateParticipant(updatedUser).subscribe(
        (response) => {
          this.loginManagement.currentUser.next(response);
          this.router.navigate(['/home']);
        },
        (error) => {
          this.error = error.status;
          console.log(error);
        }
      );
    }
  }

  pseudoNotValid() {
    return this.invalidField('pseudo');
  }

  firstNameNotValid() {
    return this.invalidField('firstName');
  }

  lastNameNotValid() {
    return this.invalidField('lastName');
  }

  mailNotValid() {
    return this.invalidField('mail');
  }

  passwordNotValid() {
    return this.invalidField('confirmPassword');
  }
}
