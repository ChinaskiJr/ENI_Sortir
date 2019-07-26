import {HttpEvent, HttpHandler, HttpInterceptor, HttpRequest} from '@angular/common/http';
import {Observable} from 'rxjs';
import {Injectable} from '@angular/core';

@Injectable()
export class BasicAuthHttpInterceptor implements HttpInterceptor {
  // Prefix URL for all requests to API
  private url = 'http://localhost:8000/';

  constructor() { }

  // Add HTTP Basic auth token for every requests to the API
  intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    const authReq = req.clone({
      url: this.url + req.url,
      setHeaders: {
        Authorization: 'Basic ' + btoa('eni_user:P4$$w0rd!')
      }
    });

    return next.handle(authReq);
  }
}
