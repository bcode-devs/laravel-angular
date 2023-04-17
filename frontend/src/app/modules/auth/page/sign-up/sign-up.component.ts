import {Component} from '@angular/core';
import {
  FormBuilder,
  FormGroup,
} from "@angular/forms";
import {AuthService} from "../../../../shared/services/auth/auth.service";
import {Router} from "@angular/router";
import {HttpErrorResponse} from "@angular/common/http";
import {setValidationErrors} from "../../../../shared/helpers/form-helpers";
import {first} from "rxjs";
import {tap} from "rxjs/operators";

@Component({
  selector: 'app-sign-up',
  templateUrl: './sign-up.component.html',
  styleUrls: ['./sign-up.component.scss']
})
export class SignUpComponent {

  // @ts-ignore
  form: FormGroup;

  constructor(
    private formBuilder: FormBuilder,
    private authService: AuthService,
    private router: Router,
  ) {
  }

  ngOnInit() {
    this.form = this.formBuilder.group({
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
    });
  }

  signUp() {
    this.form.disable();
    this.authService.register(this.form.value)
      .pipe(
        first(),
        tap(() => this.form.enable(), () => this.form.enable()),
      )
      .subscribe(
        () => this.router.navigateByUrl('/auth/verify'),
        (error: HttpErrorResponse) => setValidationErrors(this.form, error)
      );
  }
}
