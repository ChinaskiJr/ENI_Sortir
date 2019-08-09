import { Injectable } from '@angular/core';
import {City} from '../models/City';
import {Observable} from 'rxjs';
import {HttpClient} from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class CitiesManagementService {

  constructor(private httpClient: HttpClient) { }

  /**
   * Get all cities from the API
   */
  public getCities(): Observable<City[]> {
    return this.httpClient.get<City[]>('cities');
  }
}
