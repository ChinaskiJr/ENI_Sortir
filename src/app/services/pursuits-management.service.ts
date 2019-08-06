import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Site} from '../models/Site';
import {Observable} from 'rxjs';
import {Pursuit} from '../models/Pursuit';

@Injectable({
  providedIn: 'root'
})
export class PursuitsManagementService {

  constructor(private httpClient: HttpClient) { }

  public getPursuitsBySite(site: Site): Observable<Pursuit[]> {
    return this.httpClient.get<Pursuit[]>('pursuits/site/' + site.nbSite);
  }
  public postPursuit(pursuit: Pursuit): Observable<Pursuit> {
    const url =
      'organizer/' + pursuit.organizer.nbParticipant +
      '/state/' + pursuit.state.nbState +
      '/location/' + pursuit.location.nbLocation +
      '/site/' + pursuit.site.nbSite +
      '/pursuits';
    return this.httpClient.post<Pursuit>(url, pursuit);
  }

  public getPursuitByNb(nbPursuit: number): Observable<Pursuit> {
    return this.httpClient.get<Pursuit>('pursuits/' + nbPursuit);
  }

  putPursuit(pursuit: Pursuit): Observable<Pursuit> {
    console.log(pursuit.state.nbState);
    return this.httpClient.put<Pursuit>('pursuit', pursuit);
  }
}
