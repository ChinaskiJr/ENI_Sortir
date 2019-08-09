import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Observable} from 'rxjs';
import {Site} from '../models/Site';

@Injectable({
  providedIn: 'root'
})
export class SitesManagementService {

  constructor(private httpClient: HttpClient) { }

  /**
   * Get all sites from the API
   */
  public getSites(): Observable<Site[]> {
    return this.httpClient.get<Site[]>('sites');
  }
}
