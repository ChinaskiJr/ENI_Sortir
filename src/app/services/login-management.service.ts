import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Participant} from '../models/Participant';
import {BehaviorSubject, Observable} from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class LoginManagementService {

  public isUserLoggedIn: BehaviorSubject<boolean> = new BehaviorSubject<boolean>(false);
  constructor(private httpClient: HttpClient) {}

  static createLoginUrl(username, password): string {
    return 'participants/' + username + '/logins/' + password;
  }

  static storeCurrentUser(participant: Participant): void {
    localStorage.setItem('currentUser', JSON.stringify(participant));
  }

  public logoutCurrentUser(): void {
    if (localStorage.getItem('currentUser')) {
      localStorage.removeItem('currentUser');
    }
    this.isUserLoggedIn.next(false);

  }

  public loginParticipant(username, password): Observable<Participant> {
    return this.httpClient.get<Participant>(
      LoginManagementService.createLoginUrl(username, password),
    );
  }
}
