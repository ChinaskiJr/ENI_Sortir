import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Observable} from 'rxjs';
import {Participant} from '../models/Participant';

@Injectable({
  providedIn: 'root'
})
export class ParticipantManagementService {

  constructor(private httpClient: HttpClient) { }
  public putUpdateParticipant(participant: Participant): Observable<Participant> {
    return this.httpClient.put<Participant>('participant/update', participant);
  }
  public getParticipantByPseudo(pseudo: string): Observable<Participant> {
    return this.httpClient.get<Participant>('participant/pseudo/' + pseudo);
  }
  public getParticipantPictureByPseudo(pseudo: string) {
    return this.httpClient.get('participant/' + pseudo + '/picture',
      {
        headers: {'Content-Type': 'image/*'},
        responseType: 'blob'
      });
  }
}
