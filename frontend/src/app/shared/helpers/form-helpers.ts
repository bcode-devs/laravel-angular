import { HttpErrorResponse } from '@angular/common/http';
import { FormGroup } from '@angular/forms';

export function setValidationErrors(form: FormGroup, errorResponse: HttpErrorResponse) {
  const error = errorResponse.error;

  if (!error || !(error instanceof Object)) {
    return;
  }

  const errors = error.errors;
  if (!(error instanceof Object)) {
    return;
  }

  Object.entries(errors).forEach(([key, messages]) => {
    const control = form.get(key);

    if (control) {
      // @ts-ignore
      control.setErrors(messages);
    }
  });
}
