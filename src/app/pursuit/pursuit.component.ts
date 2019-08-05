import { Component, OnInit } from '@angular/core';
import {Pursuit} from '../models/Pursuit';
import {ActivatedRoute} from '@angular/router';
import {PursuitsManagementService} from '../services/pursuits-management.service';

@Component({
  selector: 'app-pursuit',
  templateUrl: './pursuit.component.html',
  styleUrls: ['./pursuit.component.css']
})
export class PursuitComponent implements OnInit {
  pursuit: Pursuit;

  constructor(private route: ActivatedRoute,
              private pursuitManagement: PursuitsManagementService) { }

  ngOnInit() {
    this.pursuitManagement.getPursuitByNb(this.route.snapshot.params.nbPursuit).subscribe(
      value => {
        this.pursuit = value;
      }
    );
  }
}
