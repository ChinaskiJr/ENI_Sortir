import {Component, OnInit} from '@angular/core';
import {LoginManagementService} from './services/login-management.service';
import {CookieService} from 'ngx-cookie-service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit {
  title = 'angular-frontend';

  constructor(private loginManagement: LoginManagementService,
              private cookieService: CookieService) { }

  /**
   * Check if a user is remembered, and log him in if it is
   */
  ngOnInit(): void {
    if (this.cookieService.check('sortir-user') && this.cookieService.check('sortir-token')) {
      this.loginManagement.checkIfWeRememberCurrentUser().subscribe(
        (participant) => {
          this.loginManagement.storeCurrentUser(participant);
      },
        (error) => {
          console.log('Error : ' + error.status + ':' + error.message);
          this.loginManagement.logoutCurrentUser();
        }
      );
    }
  }
}
