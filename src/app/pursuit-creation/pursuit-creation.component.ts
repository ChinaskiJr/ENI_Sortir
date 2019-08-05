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
import {Router} from '@angular/router';
import {startDateMustBeAfterEndDate} from '../helpers/DateValidators';

@Component({
  selector: 'app-pursuit-creation',
  templateUrl: './pursuit-creation.component.html',
  styleUrls: ['./pursuit-creation.component.css']
})
export class PursuitCreationComponent implements OnInit {

  constructor(private formBuilder: FormBuilder,
              private loginManagement: LoginManagementService,
              private citiesManagement: CitiesManagementService,
              private locationsManagement: LocationsManagementService,
              private statesManagement: StatesManagementService,
              private pursuitsManagement: PursuitsManagementService,
              private router: Router) {
  }
  pursuitForm: FormGroup;
  locationForm: FormGroup;
  currentUser: Participant;
  cities: City[];
  locations: BehaviorSubject<Location[]> = new BehaviorSubject<Location[]>(null);
  currentLocation: BehaviorSubject<Location> = new BehaviorSubject<Location>(null);
  currentCity: City;
  states: State[];

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
      nbMaxRegistrations: ['', [Validators.required, Validators.min(2)]],
      duration: ['', [Validators.required, Validators.min(5) ]],
      description: ['', Validators.required],
      city: ['', Validators.required],
      location: ['', Validators.required],
    }, {
      validators: startDateMustBeAfterEndDate('endDate', 'startDate')
    });
    this.locationForm = this.formBuilder.group({
      locationName: ['', Validators.required],
      street: ['', Validators.required],
      latitude: ['', Validators.required],
      longitude: ['', Validators.required]
    });
  }

  /**
   * When a city is selected, update the locations
   */
  onSelectCity() {
    const formCityValue = this.pursuitForm.value.city;
    // tslint:disable-next-line:triple-equals
    this.currentCity = this.cities.find(city => city.nbCity == formCityValue);
    this.locationsManagement.getLocationsByCity(this.currentCity).subscribe(
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
    if (!this.issueValidation(this.pursuitForm)) {
      const stateInCreation: State = this.states.find((state) => state.word === 'En création');
      const newPursuit = this.hydratePursuit(formValues);
      newPursuit.state = stateInCreation;
      this.pursuitsManagement.postPursuit(newPursuit).subscribe();
      this.router.navigate(['/home']);
    }
  }

  onPublish() {
    const formValues = this.pursuitForm.value;
    if (!this.issueValidation(this.pursuitForm)) {
      const stateOpen: State = this.states.find((state) => state.word === 'Ouvert');
      const newPursuit = this.hydratePursuit(formValues);
      newPursuit.state = stateOpen;
      this.pursuitsManagement.postPursuit(newPursuit).subscribe();
      this.router.navigate(['/home']);
    }
  }

  onNewLocation() {
    const formValues = this.locationForm.value;
    if (!this.issueValidation(this.locationForm)) {
      const newLocation: Location = this.hydrateLocation(formValues);
      this.locationsManagement.postLocation(newLocation).subscribe(
        () => {},
        () => {},
        () => {
          // Reload after submit
          this.locationsManagement.getLocationsByCity(this.currentCity).subscribe(
            value => this.locations.next(value)
          );
        }
      );
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

  private hydrateLocation(formValues) {
    const newLocation = new Location();
    newLocation.nameLocation = formValues.locationName;
    newLocation.street = formValues.street;
    newLocation.latitude = formValues.latitude;
    newLocation.longitude = formValues.longitude;
    newLocation.city = this.currentCity;
    return newLocation;
  }

  private invalidField(form: FormGroup, field: string) {
    return form.controls[field].invalid && (
      form.controls[field].touched ||
      form.controls[field].dirty);
  }

  private issueValidation(form: FormGroup) {
    return form.invalid || form.pristine;
  }

  nameNotValid() {
    return this.invalidField(this.pursuitForm, 'name');
  }
  startDateNotValid() {
    return this.invalidField(this.pursuitForm, 'startDate');
  }
  endDateNotValid() {
    return this.invalidField(this.pursuitForm, 'endDate');
  }
  nbMaxRegistrationsNotValid() {
    return this.invalidField(this.pursuitForm, 'nbMaxRegistrations');
  }
  durationNotValid() {
    return this.invalidField(this.pursuitForm, 'duration');
  }
  descriptionNotValid() {
    return this.invalidField(this.pursuitForm, 'description');
  }
  cityNotValid() {
    return this.invalidField(this.pursuitForm, 'city');
  }
  locationNotValid() {
    return this.invalidField(this.pursuitForm, 'location');
  }
  locationNameNotValid() {
    return this.invalidField(this.locationForm, 'locationName');
  }
  streetNotValid() {
    return this.invalidField(this.locationForm, 'street');
  }
  latitudeNotValid() {
    return this.invalidField(this.locationForm, 'latitude');
  }
  longitudeNotValid() {
    return this.invalidField(this.locationForm, 'longitude');
  }
}
