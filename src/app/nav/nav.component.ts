import { Component, OnInit } from '@angular/core';
import {LoginManagementService} from '../services/login-management.service';

@Component({
  selector: 'app-nav',
  templateUrl: './nav.component.html',
  styleUrls: ['./nav.component.css']
})
export class NavComponent implements OnInit {
  isUserLoggedIn: boolean;
  currentUser: any;

  constructor(private loginManagement: LoginManagementService) {

  }

  ngOnInit() {
    this.loginManagement.isUserLoggedIn.subscribe(
      value => {
        this.isUserLoggedIn = value;
      }
    );
    this.loginManagement.currentUser.subscribe(
      value => {
        this.currentUser = value;
      }
    );

  }

  onDisconnect() {
    this.loginManagement.logoutCurrentUser();
  }
}
