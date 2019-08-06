import {Component, OnInit} from '@angular/core';
import {Pursuit} from '../models/Pursuit';
import {ActivatedRoute, Router} from '@angular/router';
import {PursuitsManagementService} from '../services/pursuits-management.service';
import {Participant} from '../models/Participant';
import {LoginManagementService} from '../services/login-management.service';
import {State} from '../models/State';
import {StatesManagementService} from '../services/states-management.service';

@Component({
  selector: 'app-pursuit',
  templateUrl: './pursuit.component.html',
  styleUrls: ['./pursuit.component.css']
})
export class PursuitComponent implements OnInit {
  pursuit: Pursuit;
  currentUser: Participant;
  states: State[];

  constructor(private route: ActivatedRoute,
              private pursuitManagement: PursuitsManagementService,
              private loginManagement: LoginManagementService,
              private stateManagement: StatesManagementService,
              private router: Router) { }

  ngOnInit() {
    this.pursuitManagement.getPursuitByNb(this.route.snapshot.params.nbPursuit).subscribe(
      value => {
        this.pursuit = value;
      }
    );
    this.loginManagement.currentUser.subscribe(
      value => this.currentUser = value
    );
    this.stateManagement.getAllStates().subscribe(
      value => this.states = value
    );

  }

  /**
   * Publish a pursuit that was recorded
   */
  onPublish() {
    // Get the id of the "Ouvert" state
    this.pursuit.state = this.states.find((state) => state.word === 'Ouvert');
    // Update
    this.pursuitManagement.putPursuit(this.pursuit).subscribe(
      value => console.log(value),
      () => {},
      // When it's done, redirect to home
      () => this.router.navigate(['/home'])
    );
  }
}
