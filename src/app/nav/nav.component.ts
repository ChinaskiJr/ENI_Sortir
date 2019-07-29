import { Component, OnInit } from '@angular/core';
import {LoginManagementService} from '../services/login-management.service';

@Component({
  selector: 'app-nav',
  templateUrl: './nav.component.html',
  styleUrls: ['./nav.component.css']
})
export class NavComponent implements OnInit {
  currentUser: any = null;
  isUserLoggedIn: boolean;

  constructor(private loginManagement: LoginManagementService) {
    // Are we connected ?
    if (localStorage.getItem('currentUser')) {
      this.currentUser = JSON.parse(localStorage.getItem('currentUser'));
    }
    // In every case, we have to listen :)
    this.loginManagement.isUserLoggedIn.subscribe(
      value => { this.isUserLoggedIn = value; }
    );
  }

  ngOnInit() {
  }

  onDisconnect() {
    this.loginManagement.logoutCurrentUser(this.currentUser);
  }
}
