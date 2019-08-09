import { FormGroup} from '@angular/forms';

/**
 * Custom validator checks if a date is before another one
 */
export function startDateMustBeAfterEndDate(startDate: string, endDate: string) {
  return (formGroup: FormGroup) => {
    const controlStartDate = formGroup.controls[startDate];
    const controlEndDate = formGroup.controls[endDate];
    if (controlStartDate && controlEndDate) {
      if (controlStartDate.value >= controlEndDate.value) {
        controlStartDate.setErrors({startDateError: true});
      } else {
        controlStartDate.setErrors(null);
      }
    }
  };
}

/**
 * Custom validator checks if a date is not before the current date
 */
export function dateMustNotBeBeforeNow(dateToTest: string) {
  return (formGroup: FormGroup) => {
    const controlDateToTest = formGroup.controls[dateToTest];
    if (new Date(controlDateToTest.value) <= new Date()) {
      controlDateToTest.setErrors({dateBeforeToday: true});
    } else {
      controlDateToTest.setErrors(null);
    }
  };
}
