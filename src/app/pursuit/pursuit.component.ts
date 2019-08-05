import { Component, OnInit } from '@angular/core';
import {Pursuit} from '../models/Pursuit';
import {ActivatedRoute} from '@angular/router';
import {PursuitsManagementService} from '../services/pursuits-management.service';
import {Participant} from '../models/Participant';
import {LoginManagementService} from '../services/login-management.service';

@Component({
  selector: 'app-pursuit',
  templateUrl: './pursuit.component.html',
  styleUrls: ['./pursuit.component.css']
})
export class PursuitComponent implements OnInit {
  pursuit: Pursuit;
  currentUser: Participant;

  constructor(private route: ActivatedRoute,
              private pursuitManagement: PursuitsManagementService,
              private loginManagement: LoginManagementService) { }

  ngOnInit() {
    this.pursuitManagement.getPursuitByNb(this.route.snapshot.params.nbPursuit).subscribe(
      value => {
        this.pursuit = value;
      }
    );
    this.loginManagement.currentUser.subscribe(
      value => this.currentUser = value
    );
  }
}
