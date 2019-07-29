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
        password: ['', Validators.required],
        rememberMe: ['']
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

  /**
   * Login the user, call the service for tokens if "remember me" was checked
   */
  onLogin() {
    const formValue = this.loginForm.value;
    if (!this.issueValidation()) {
      // GET call to the API
      this.loginManager.loginParticipant(formValue.pseudo, formValue.password)
        .subscribe(
          (response) => {
            this.participant = response;
            // If no remember me : only store our user in the localStorage
            this.loginManager.storeCurrentUser(this.participant);
            // else also in cookies :
            if (formValue.rememberMe) {
               this.loginManager.rememberCurrentUser(this.participant).subscribe();
            }
            this.router.navigate(['/home']);
          },
          (error) => {
            this.error = error.status;
            console.log('Error : ' + error.status + ':' + error.message);
          });
    }
  }
}
