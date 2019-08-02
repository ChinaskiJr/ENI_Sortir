import { Component, OnInit } from '@angular/core';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {Participant} from '../models/Participant';
import {LoginManagementService} from '../services/login-management.service';
import {City} from '../models/City';
import {CitiesManagementService} from '../services/cities-management.service';
import {BehaviorSubject} from 'rxjs';
import {Location} from '../models/Location';
import {LocationsManagementService} from '../services/locations-management.service';
import {Pursuit} from '../models/Pursuit';
import {State} from '../models/State';
import {StatesManagementService} from '../services/states-management.service';
import {PursuitsManagementService} from '../services/pursuits-management.service';

@Component({
  selector: 'app-pursuit-creation',
  templateUrl: './pursuit-creation.component.html',
  styleUrls: ['./pursuit-creation.component.css']
})
export class PursuitCreationComponent implements OnInit {
  pursuitForm: FormGroup;
  currentUser: Participant;
  cities: City[];
  locations: BehaviorSubject<Location[]> = new BehaviorSubject<Location[]>(null);
  currentLocation: BehaviorSubject<Location> = new BehaviorSubject<Location>(null);
  states: State[];

  constructor(private formBuilder: FormBuilder,
              private loginManagement: LoginManagementService,
              private citiesManagement: CitiesManagementService,
              private locationsManagement: LocationsManagementService,
              private statesManagement: StatesManagementService,
              private pursuitsManagement: PursuitsManagementService) {
  }

  ngOnInit() {
    this.loginManagement.currentUser.subscribe(
      value => {
        this.currentUser = new Participant();
        this.currentUser = value;
        this.initForm();
      }
    );
    this.citiesManagement.getCities().subscribe(
      value => this.cities = value
    );
    this.statesManagement.getAllStates().subscribe(
      value => this.states = value
    );
  }

  initForm() {
    this.pursuitForm = this.formBuilder.group({
      name: ['', Validators.required],
      startDate: ['', Validators.required],
      endDate: ['', Validators.required],
      nbMaxRegistrations: ['', Validators.required],
      duration: ['', Validators.required],
      description: ['', Validators.required],
      city: ['', Validators.required],
      location: ['', Validators.required],
    });
    // TODO : Valider les dates
    // TODO : Valider les nombres (nbMaxRegistration & duree > 0 par ex)
  }

  /**
   * When a city is selected, update the locations
   */
  onSelectCity() {
    const formCityValue = this.pursuitForm.value.city;
    // tslint:disable-next-line:triple-equals
    const cityInstance = this.cities.find(city => city.nbCity == formCityValue);
    this.locationsManagement.getLocationsByCity(cityInstance).subscribe(
      value => this.locations.next(value)
    );
  }

  /**
   * When a location is selected, display informations about it
   */
  onSelectLocation() {
    const formLocationValue = this.pursuitForm.value.location;
    // tslint:disable-next-line:triple-equals
    const locationInstance = this.locations.value.find(location => location.nbLocation == formLocationValue);
    this.currentLocation.next(locationInstance);
  }

  onRecord() {
    const formValues = this.pursuitForm.value;
    if (!this.issueValidation()) {
      const stateInCreation: State = this.states.find((state) => state.word === 'En création');
      const newPursuit = this.hydratePursuit(formValues);
      newPursuit.state = stateInCreation;
      this.pursuitsManagement.postPursuit(newPursuit).subscribe();
      // TODO : Rerouter vers home ensuite
    }
  }

  onPublish() {
    const formValues = this.pursuitForm.value;
    if (!this.issueValidation()) {
      const stateOpen: State = this.states.find((state) => state.word === 'Ouvert');
      const newPursuit = this.hydratePursuit(formValues);
      newPursuit.state = stateOpen;
      this.pursuitsManagement.postPursuit(newPursuit).subscribe();
      // TODO : Rerouter vers home ensuite
    }
  }

  private hydratePursuit(formValues) {
    const newPursuit = new Pursuit();
    newPursuit.name = formValues.name;
    newPursuit.dateStart = formValues.startDate;
    // To conform to API date format
    newPursuit.dateEnd = formValues.endDate + 'T00:00';
    newPursuit.nbMaxRegistrations = formValues.nbMaxRegistrations;
    newPursuit.duration = formValues.duration;
    newPursuit.description = formValues.description;
    newPursuit.location = this.currentLocation.value;
    newPursuit.organizer = this.currentUser;
    newPursuit.site = this.currentUser.site;
    return newPursuit;
  }

  private invalidField(field: string) {
    return this.pursuitForm.controls[field].invalid && (
      this.pursuitForm.controls[field].touched ||
      this.pursuitForm.controls[field].dirty);
  }

  private issueValidation() {
    return this.pursuitForm.invalid || this.pursuitForm.pristine;
  }

  nameNotValid() {
    return this.invalidField('name');
  }
  startDateNotValid() {
    return this.invalidField('startDate');
  }
  endDateNotValid() {
    return this.invalidField('endDate');
  }
  nbMaxRegistrationsNotValid() {
    return this.invalidField('nbMaxRegistrations');
  }
  durationNotValid() {
    return this.invalidField('duration');
  }
  descriptionNotValid() {
    return this.invalidField('description');
  }
  cityNotValid() {
    return this.invalidField('city');
  }
  locationNotValid() {
    return this.invalidField('location');
  }
}
