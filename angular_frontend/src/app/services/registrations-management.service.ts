import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Registration} from '../models/Registration';
import {Observable} from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class RegistrationsManagementService {

  constructor(private httpClient: HttpClient) { }

  public postRegistration(nbPursuit: number, nbParticipant: number): Observable<Registration> {
    return this.httpClient.post<Registration>('registration/pursuit/' + nbPursuit + '/participant/' + nbParticipant, null);
  }

  public deleteRegistration(nbPursuit: number, nbParticipant: number): Observable<null> {
    return this.httpClient.delete<null>('registration/pursuit/' + nbPursuit + '/participant/' + nbParticipant);
  }
}
