import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Participant} from '../models/Participant';
import {BehaviorSubject, Observable} from 'rxjs';
import { CookieService } from 'ngx-cookie-service';

@Injectable({
  providedIn: 'root'
})
export class LoginManagementService {

  public isUserLoggedIn: BehaviorSubject<boolean> = new BehaviorSubject<boolean>(false);

  constructor(private httpClient: HttpClient,
              private cookieService: CookieService) {
  }

  /**
   * Dynamically create the URL for GET login request
   */
  static createLoginUrl(username, password): string {
    return 'participants/' + username + '/logins/' + password;
  }

  /**
   * Store the user passed in argument as the logged in user in local storage
   * @param participant The user to log in
   */
  public storeCurrentUser(participant: Participant): void {
    localStorage.setItem('currentUser', JSON.stringify(participant));
    // Update the observable
    this.isUserLoggedIn.next(true);
  }

  /**
   * Part of "remember me" spec
   * Two cookies created :
   * random token to send to the database (where it should be encrypted)
   * the user
   */
  public rememberCurrentUser(participant: Participant): Observable<object> {
    // SECURITY MATTERS
    // Random string :
    const random = Math.random().toString(36).substring(7);
    // Set this as cookie
    this.cookieService.set('sortir-user', participant.pseudo, 31);
    this.cookieService.set('sortir-token', random, 31);
    // Store in the DB where it will be encrypt
    return this.httpClient.post<object>('participants/tokens', {
      pseudo: participant.pseudo,
      token: random
    });
  }

  /**
   * Part of "remember me" spec
   * Check with the api if the tokens matched a user
   */
  public checkIfWeRememberCurrentUser(): Observable<Participant> {
    const user = this.cookieService.get('sortir-user');
    const token = this.cookieService.get('sortir-token');
    return this.httpClient.get<Participant> (
      'participants/' + user + '/tokens/' + token
    );
  }

  /**
   * Log out the user : destroy cookies and localstorage
   */
  public logoutCurrentUser(): void {
    if (localStorage.getItem('currentUser')) {
      this.cookieService.delete('sortir-user');
      this.cookieService.delete('sortir-token');
      localStorage.removeItem('currentUser');
    }
    this.isUserLoggedIn.next(false);

  }

  /**
   * Check for the match username/password with the API
   */
  public loginParticipant(username, password): Observable<Participant> {
    return this.httpClient.get<Participant>(
      LoginManagementService.createLoginUrl(username, password),
    );
  }
}
