import { Component, OnInit } from '@angular/core';
import {Participant} from '../models/Participant';
import {LoginManagementService} from '../services/login-management.service';
import {Pursuit} from '../models/Pursuit';
import {PursuitsManagementService} from '../services/pursuits-management.service';
import {Site} from '../models/Site';
import {SitesManagementService} from '../services/sites-management.service';
import {Registration} from '../models/Registration';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {
  currentUser: Participant;
  sites: Site[];
  currentSite: Site;
  pursuits: Pursuit[];

  constructor(private loginManagement: LoginManagementService,
              private pursuitManagement: PursuitsManagementService,
              private siteManagement: SitesManagementService) { }

  ngOnInit() {
    this.loginManagement.currentUser.subscribe(
      value => {
        this.currentUser = new Participant();
        this.currentUser = value;
      }
    );
    this.siteManagement.getSites().subscribe(
      value => {
        this.sites = value;
      });
    this.currentSite = this.currentUser.site;
    this.pursuitManagement.getPursuitsBySite(this.currentSite).subscribe(
      value => {
        this.pursuits = value;
      }
    );
  }

  checkForRegistration(registrations: Registration[]) {
    let registered = false;
    for (const registration of registrations) {
      if (registration.participant.nbParticipant === this.currentUser.nbParticipant) {
        registered = true;
      }
    }
    return registered;
  }
}
