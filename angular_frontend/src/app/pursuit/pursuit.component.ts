import {Component, OnInit} from '@angular/core';
import {Pursuit} from '../models/Pursuit';
import {ActivatedRoute, Router} from '@angular/router';
import {PursuitsManagementService} from '../services/pursuits-management.service';
import {Participant} from '../models/Participant';
import {LoginManagementService} from '../services/login-management.service';
import {State} from '../models/State';
import {StatesManagementService} from '../services/states-management.service';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';

@Component({
  selector: 'app-pursuit',
  templateUrl: './pursuit.component.html',
  styleUrls: ['./pursuit.component.css']
})
export class PursuitComponent implements OnInit {
  pursuit: Pursuit;
  currentUser: Participant;
  states: State[];
  cancelForm: FormGroup;
  error: any;

  constructor(private route: ActivatedRoute,
              private pursuitManagement: PursuitsManagementService,
              private loginManagement: LoginManagementService,
              private stateManagement: StatesManagementService,
              private router: Router,
              private formBuilder: FormBuilder) {
  }

  ngOnInit() {
    this.pursuitManagement.getPursuitByNb(this.route.snapshot.params.nbPursuit).subscribe(
      value => {
        this.pursuit = value;
      },
      error => {
        if (error.status === 404) {
          this.router.navigate(['/home']);
        }
      }
    );
    this.loginManagement.currentUser.subscribe(
      value => this.currentUser = value
    );
    this.stateManagement.getAllStates().subscribe(
      value => this.states = value
    );
    this.initForm();
  }

  initForm() {
    this.cancelForm = this.formBuilder.group({
      message: ['', [Validators.required, Validators.maxLength(30)]]
    });
  }

  private invalidField(field: string) {
    return this.cancelForm.controls[field].invalid && (
      this.cancelForm.controls[field].dirty ||
      this.cancelForm.controls[field].touched
    );
  }

  private issueValidation() {
    return this.cancelForm.invalid || this.cancelForm.pristine;
  }

  messageNotValid() {
    return this.invalidField('message');
  }

  /**
   * Publish a pursuit that was recorded
   */
  onPublish() {
    // Get the id of the "Ouvert" state
    this.pursuit.state = this.states.find((state) => state.word === 'Ouvert');
    // Update
    this.pursuitManagement.putPursuit(this.pursuit).subscribe(
      () => {},
      () => {},
      // When it's done, redirect to home
      () => this.router.navigate(['/home'])
    );
  }

  onCancel() {
    // Get he id of the "Annulé" state
    this.pursuit.state = this.states.find((state) => state.word === 'Annulé');
    // Set the message in the description
    this.pursuit.description = this.pursuit.description + '\n' + this.cancelForm.value.message;
    // Update
    this.pursuitManagement.putPursuit(this.pursuit).subscribe(
      () => {},
      () => {},
      // When it's done, redirect to home
      () => this.router.navigate(['/home'])
    );
  }
}
