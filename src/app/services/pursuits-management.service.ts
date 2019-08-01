import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Site} from '../models/Site';
import {Observable} from 'rxjs';
import {Pursuit} from '../models/Pursuit';

@Injectable({
  providedIn: 'root'
})
export class PursuitsManagementService {

  constructor(private httpClient: HttpClient) { }

  public getPursuitsBySite(site: Site): Observable<Pursuit[]> {
    return this.httpClient.get<Pursuit[]>('pursuits/site/' + site.nbSite);
  }
}
