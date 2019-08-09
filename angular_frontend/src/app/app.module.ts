import { BrowserModule } from '@angular/platform-browser';
import {LOCALE_ID, NgModule} from '@angular/core';
import { registerLocaleData } from '@angular/common';
import localeFr from '@angular/common/locales/fr';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { HeaderComponent } from './header/header.component';
import { HomeComponent } from './home/home.component';
import { LoginComponent } from './login/login.component';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import { ErrorComponent } from './error/error.component';
import { NavComponent } from './nav/nav.component';
import {HttpClientModule, HTTP_INTERCEPTORS} from '@angular/common/http';
import {BasicAuthHttpInterceptor} from './helpers/BasicAuthHttpInterceptor';
import { CookieService } from 'ngx-cookie-service';
import { ProfileComponent } from './profile/profile.component';
import {AuthGuardService} from './services/auth-guard.service';
import { PursuitCreationComponent } from './pursuit-creation/pursuit-creation.component';
import { PursuitComponent } from './pursuit/pursuit.component';

// Set up the locale to french
registerLocaleData(localeFr, 'fr');

@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    HomeComponent,
    LoginComponent,
    ErrorComponent,
    NavComponent,
    ProfileComponent,
    PursuitCreationComponent,
    PursuitComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    FormsModule,
    ReactiveFormsModule,
    HttpClientModule,
  ],
  providers: [
    { provide: LOCALE_ID, useValue: 'fr' },
    { provide: HTTP_INTERCEPTORS, useClass: BasicAuthHttpInterceptor, multi: true },
    CookieService,
    AuthGuardService
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
