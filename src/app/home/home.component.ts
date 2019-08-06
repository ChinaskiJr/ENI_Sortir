import { Component, OnInit } from '@angular/core';
import {Participant} from '../models/Participant';
import {LoginManagementService} from '../services/login-management.service';
import {Pursuit} from '../models/Pursuit';
import {PursuitsManagementService} from '../services/pursuits-management.service';
import {Site} from '../models/Site';
import {SitesManagementService} from '../services/sites-management.service';
import {Registration} from '../models/Registration';
import {FormBuilder, FormGroup} from '@angular/forms';
import {startDateMustBeAfterEndDate} from '../helpers/DateValidators';
import {BehaviorSubject} from 'rxjs';
import {RegistrationsManagementService} from '../services/registrations-management.service';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {
  currentUser: Participant;
  sites: Site[];
  currentSite: BehaviorSubject<Site> = new BehaviorSubject<Site>(null);
  pursuits: BehaviorSubject<Pursuit[]> = new BehaviorSubject<Pursuit[]>(null);
  filterPursuitsForm: FormGroup;
  error: string;

  get now(): string { return Date(); }

  constructor(private loginManagement: LoginManagementService,
              private pursuitManagement: PursuitsManagementService,
              private siteManagement: SitesManagementService,
              private formBuilder: FormBuilder,
              private registrationManagement: RegistrationsManagementService) {
    this.createForm();
  }

  ngOnInit() {
    this.loginManagement.currentUser.subscribe(
      value => {
        this.currentUser = new Participant();
        this.currentUser = value;
      }
    );
    this.siteManagement.getSites().subscribe(
      value => {
        this.sites = value;
      });
    this.currentSite.next(this.currentUser.site);
    this.pursuitManagement.getPursuitsExceptArchivedBySite(this.currentSite.value).subscribe(
      value => {
        this.pursuits.next(value);
      }
    );
  }

  createForm() {
    this.filterPursuitsForm = this.formBuilder.group({
      site: [],
      pursuitsContains: [],
      startDate: [],
      endDate: [],
      amIOrganizer: [],
      didISubscribe: [],
      didINotSubscribe: [],
      didThisEnded: []
    }, {
      validators: startDateMustBeAfterEndDate('startDate', 'endDate')
    });
  }

  private invalidField(field: string) {
    return this.filterPursuitsForm.controls[field].invalid &&
      (this.filterPursuitsForm.controls[field].dirty);
  }

  issueValidation() {
    return this.filterPursuitsForm.pristine;
  }

  /**
   * First, we reload the pursuits, and when HTTP requests
   * will be done, we will call the function doFilter()
   */
  onSubmitFilter() {
    const formValue = this.filterPursuitsForm.value;

    if (!this.issueValidation()) {
      // Filter by Site
      if (formValue.site) {
        if (this.currentSite.value.nbSite !== formValue.site) {
          // tslint:disable-next-line:triple-equals
          this.currentSite.next(this.sites.find(site => site.nbSite == formValue.site));
          this.pursuitManagement.getPursuitsBySite(this.currentSite.value).subscribe(
            value => {
              this.pursuits.next(value);
            },
            null,
            () => {
              this.doFilter(formValue);
            }
          );
        }
      } else {
        // Before every call we have to reload all list
        this.pursuitManagement.getPursuitsBySite(this.currentSite.value).subscribe(
          value => {
            this.pursuits.next(value);
          },
          null,
          () => {
            this.doFilter(formValue);
          }
        );
      }
    }
  }

  /**
   * Perform all the requested form filters
   */
  doFilter(formValue) {
    // Filter by word
    if (formValue.pursuitsContains) {
      this.pursuits.next(
        this.pursuits.value.filter(pursuit =>
          pursuit.name.toLowerCase().includes(formValue.pursuitsContains.toLowerCase())
        )
      );
    }
    // Filter by date
    if (formValue.startDate && formValue.endDate) {
      this.pursuits.next(
        this.pursuits.value.filter(pursuit =>
          pursuit.dateStart >= formValue.startDate && pursuit.dateEnd <= formValue.endDate
        )
      );
    }
    // Now the checkboxes :
    if (formValue.amIOrganizer) {
      this.pursuits.next(
        this.pursuits.value.filter(pursuit =>
          pursuit.organizer.nbParticipant === this.currentUser.nbParticipant
        )
      );
    }
    if (formValue.didISubscribe) {
      this.pursuits.next(
        this.pursuits.value.filter(pursuit =>
          this.checkForRegistration(pursuit.registrations)
        )
      );
    }
    if (formValue.didINotSubscribe) {
      this.pursuits.next(
        this.pursuits.value.filter(pursuit =>
          !this.checkForRegistration(pursuit.registrations)
        )
      );
    }
    if (formValue.didThisEnded) {
      this.pursuits.next(
        this.pursuits.value.filter(pursuit =>
          new Date(pursuit.dateStart) < new Date()
        )
      );
    }
  }

  /**
   * Register an user to a pursuit, check if he is not already registered
   * or if the maximum amount of registration already been reached
   */
  onRegister(pursuit: Pursuit) {
    if (pursuit.nbMaxRegistrations === pursuit.registrations.length) {
      this.error = 'nbMaxRegistrationError';
    } else {
      this.registrationManagement.postRegistration(pursuit.nbPursuit, this.currentUser.nbParticipant).subscribe(
        () => {
          this.pursuitManagement.getPursuitsBySite(this.currentSite.value).subscribe(
            value => {
              this.pursuits.next(value);
            });
        },
        (error) => {
          this.error = error.status;
        }
      );
    }
  }

  /**
   * Desist an user from a pursuit
   */
  onDesist(pursuit: Pursuit) {
    this.registrationManagement.deleteRegistration(pursuit.nbPursuit, this.currentUser.nbParticipant).subscribe(
      () => {
        this.pursuitManagement.getPursuitsBySite(this.currentSite.value).subscribe(
          value => {
            this.pursuits.next(value);
          });
      },
      (error) => {
        this.error = error.status;
        console.log(error);
      }
    );
  }

  startDateNotValid() {
    return this.invalidField('startDate');
  }

  /**
   * Check if the currentUser subscribed to this pursuit
   */
  checkForRegistration(registrations: Registration[]) {
    let registered = false;
    for (const registration of registrations) {
      if (registration.participant.nbParticipant === this.currentUser.nbParticipant) {
        registered = true;
      }
    }
    return registered;
  }

}
