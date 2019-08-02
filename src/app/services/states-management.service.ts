import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Observable} from 'rxjs';
import {State} from '../models/State';

@Injectable({
  providedIn: 'root'
})
export class StatesManagementService {

  constructor(private httpClient: HttpClient) { }

  getAllStates(): Observable<State[]> {
    return this.httpClient.get<State[]>('states');
  }
}
