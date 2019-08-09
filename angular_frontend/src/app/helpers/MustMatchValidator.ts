import {FormGroup} from '@angular/forms';

/**
 * Custom validator for password confirmation in forms
 */
export function MustMatch(firstName: string, secondName: string) {
  return (formGroup: FormGroup) => {
    const controlFirstName = formGroup.controls[firstName];
    const controlSecondName = formGroup.controls[secondName];

    if (controlFirstName.value !== controlSecondName.value) {
      controlSecondName.setErrors({mustmatch: true});
    } else {
      controlSecondName.setErrors(null);
    }
  };
}
