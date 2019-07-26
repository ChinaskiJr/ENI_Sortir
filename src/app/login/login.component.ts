import { Component, OnInit } from '@angular/core';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {Participant} from '../models/Participant';
import {Router} from '@angular/router';
import {LoginManagementService} from '../services/login-management.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {
  loginForm: FormGroup;
  participant: Participant;
  error: string;

  constructor(private formBuilder: FormBuilder,
              private loginManager: LoginManagementService,
              private router: Router) {
    this.createForm();
  }

  private createForm() {
    this.loginForm = this.formBuilder.group(
      {
        pseudo: ['', Validators.required],
        password: ['', Validators.required]
      }
    );
  }

  private invalidField(field: string) {
    return this.loginForm.controls[field].invalid &&
      (this.loginForm.controls[field].dirty ||
        this.loginForm.controls[field].touched);
  }

  ngOnInit() {
  }

  pseudoNotValid() {
    return this.invalidField('pseudo');
  }

  passwordNotValid() {
    return this.invalidField('password');
  }

  issueValidation() {
    return this.loginForm.pristine || this.loginForm.invalid;
  }

  onLogin() {
    const formValue = this.loginForm.value;
    if (!this.issueValidation()) {
      // GET call to the API
      this.loginManager.loginParticipant(formValue.pseudo, formValue.password)
        .subscribe(
          (response) => {
            this.participant = response;
            // Store our user in the localStorage
            LoginManagementService.storeCurrentUser(this.participant);
            // Update the observable
            this.loginManager.isUserLoggedIn.next(true);
            this.router.navigate(['/home']);
          },
          (error) => {
            this.error = error.status;
            console.log('Error : ' + error.status + ':' + error.message);
          });
    }
  }
}
