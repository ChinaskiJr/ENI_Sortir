import {FormGroup} from '@angular/forms';

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
