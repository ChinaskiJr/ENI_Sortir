import { Component, OnInit } from '@angular/core';
import {LoginManagementService} from '../services/login-management.service';

@Component({
  selector: 'app-nav',
  templateUrl: './nav.component.html',
  styleUrls: ['./nav.component.css']
})
export class NavComponent implements OnInit {
  isUserLoggedIn: boolean;

  constructor(private loginManagement: LoginManagementService) {
    this.loginManagement.isUserLoggedIn.subscribe(
      value => { this.isUserLoggedIn = value; }
    );
  }

  ngOnInit() {
  }

  onDisconnect() {
    this.loginManagement.logoutCurrentUser();
  }
}
