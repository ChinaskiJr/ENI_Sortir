import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {City} from '../models/City';
import {Observable} from 'rxjs';
import {Location} from '../models/Location';

@Injectable({
  providedIn: 'root'
})
export class LocationsManagementService {

  constructor(private httpClient: HttpClient) { }

  public getLocationsByCity(city: City): Observable<Location[]> {
    return this.httpClient.get<Location[]>('locations/city/' + city.nbCity);
  }

  public postLocation(location: Location): Observable<Location> {
    return this.httpClient.post<Location>('locations/city/' + location.city.nbCity, location);
  }
}
