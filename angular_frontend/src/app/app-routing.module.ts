import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import {HomeComponent} from './home/home.component';
import {ErrorComponent} from './error/error.component';
import {LoginComponent} from './login/login.component';
import {ProfileComponent} from './profile/profile.component';
import {AuthGuardService} from './services/auth-guard.service';
import {PursuitCreationComponent} from './pursuit-creation/pursuit-creation.component';
import {PursuitComponent} from './pursuit/pursuit.component';

const routes: Routes = [
  { path: '', redirectTo: '/home', pathMatch: 'full' },
  { path: 'home', canActivate: [AuthGuardService], component: HomeComponent },
  { path : 'login', component: LoginComponent },
  { path : 'profile/:pseudo', canActivate: [AuthGuardService], component: ProfileComponent },
  { path: 'pursuit/:nbPursuit', canActivate: [AuthGuardService], component: PursuitComponent },
  { path : 'pursuit_creation', canActivate: [AuthGuardService], component: PursuitCreationComponent },
  { path: '**', canActivate: [AuthGuardService], component: ErrorComponent }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
