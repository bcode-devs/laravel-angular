import {HttpErrorResponse} from "@angular/common/http";
import {FormBuilder, FormGroup} from "@angular/forms";
import {Component, Inject, OnInit, PLATFORM_ID} from '@angular/core';
import {ActivatedRoute, Router} from "@angular/router";
import {tap} from "rxjs/operators";
import {first, Subscription} from "rxjs";

import {setValidationErrors} from "../../../../shared/helpers/form-helpers";
import {AuthService} from "../../../../shared/services/auth/auth.service";
import {isPlatformBrowser} from "@angular/common";
import {MatSnackBar} from "@angular/material/snack-bar";


@Component({
  selector: 'app-reset-password',
  templateUrl: './reset-password.component.html',
  styleUrls: ['./reset-password.component.scss']
})
export class ResetPasswordComponent implements OnInit {

  form: FormGroup;
  isMailSend: boolean = false;
  isPasswordReset: boolean = false;
  private sub: Subscription | undefined;
  public queryToken: string | undefined;
  public hasQueryToken: boolean = false;


  constructor(
    private formBuilder: FormBuilder,
    private authService: AuthService,
    private router: Router,
    private route: ActivatedRoute,
    private _snackBar: MatSnackBar,
    // @ts-ignore
    @Inject(PLATFORM_ID) private platformId,
  ) {

    this.authService.signOut();

    this.form = this.formBuilder.group({
      token: this.queryToken,
      email: '',
      password: '',
      password_confirmation: '',
    });
  }

  ngOnInit() {
    if (isPlatformBrowser(this.platformId)) {
      this.sub = this.route.queryParams.subscribe(params => {
        this.queryToken = params['token']
        if (this.queryToken) {
          this.hasQueryToken = true;
          this.form.get('token')?.setValue(this.queryToken);
        }
      });
    }
  }

  resetPassword() {
    this.hasQueryToken ? this.sendResetPassword() : this.sendMail();
  }

  sendResetPassword() {
    this.form.disable();
    this.authService.resetPassword(this.form.value)
      .pipe(
        first(),
        tap(() => this.form.enable(), () => this.form.enable()),
      )
      .subscribe(
        () => {
          this.isPasswordReset = true
        },
        (error: HttpErrorResponse) => {
          if (error.status === 429) {
            return this.openSnackBar(error.error.message, '')
          }
          setValidationErrors(this.form, error)
        }
      );
  }

  sendMail() {
    this.form.disable();
    this.authService.resetSendMail(this.form.value)
      .pipe(
        first(),
        tap(() => this.form.enable(), () => this.form.enable()),
      )
      .subscribe(
        () => {
          this.isMailSend = true
        },
        (error: HttpErrorResponse) => {
          if (error.status === 429) {
            return this.openSnackBar(error.error.message, '')
          }
          setValidationErrors(this.form, error)
        }
      );
  }

  openSnackBar(message: string, action: string) {
    this._snackBar.open(message, action, {
      duration: 5000,
      horizontalPosition: 'center',
      verticalPosition:'top',
    });
  }

  ngOnDestroy(): void {
    if (this.sub) {
      this.sub.unsubscribe();
    }
  }
}
