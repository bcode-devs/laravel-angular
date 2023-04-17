import {Component, HostListener, OnInit} from '@angular/core';
import {first} from "rxjs";
import {Router} from "@angular/router";
import {FormBuilder, FormGroup} from '@angular/forms';
import {AuthService} from "../../../../shared/services/auth/auth.service";
import {tap} from "rxjs/operators";
import {HttpErrorResponse} from "@angular/common/http";
import {setValidationErrors} from "../../../../shared/helpers/form-helpers";

@Component({
  selector: 'app-sign-in',
  templateUrl: './sign-in.component.html',
  styleUrls: ['./sign-in.component.scss']
})
export class SignInComponent implements OnInit {

  // @ts-ignore
  form: FormGroup;

  constructor(
    private formBuilder: FormBuilder,
    private authService: AuthService,
    private router: Router,
  ) {
  }

  @HostListener('window:storage', ['$event'])
  onStorageChange(ev: StorageEvent) {
    if (ev.key === this.authService.jwtTokenName) {
      this.authService.signInSocial()
        .pipe(
          first(),
          tap(() => this.form.enable(), () => this.form.enable()),
        )
        .subscribe(
          () => this.router.navigateByUrl('/'),
          (error: HttpErrorResponse) => setValidationErrors(this.form, error),
        );
    }
  }

  ngOnInit() {
    this.authService.signOut();
    this.form = this.formBuilder.group({
      email: '',
      password: '',
    });
  }

  signIn() {
    this.form.disable();
    this.authService.signIn(this.form.value)
      .pipe(
        first(),
        tap(() => this.form.enable(), () => this.form.enable()),
      )
      .subscribe(
        () => this.router.navigateByUrl('/'),
        (error: HttpErrorResponse) => setValidationErrors(this.form, error),
      );
  }

  googleLogin() {
    this.authService.googleLogin()
      .pipe(
        first(),
        tap(() => this.form.enable(), () => this.form.enable()),
      )
      .subscribe(
        (data) => {
          const newWindow = this.openWindow('', 'Войти');
          // console.log('data', data);
          newWindow.location.href = data;
        },
        (error: HttpErrorResponse) => setValidationErrors(this.form, error),
      );
  }

  facebookLogin() {
    this.authService.githubFacebook()
      .pipe(
        first(),
        tap(() => this.form.enable(), () => this.form.enable()),
      )
      .subscribe(
        (data) => {
          const newWindow = this.openWindow('', 'Войти');
          // console.log('data', data);
          newWindow.location.href = data;
        },
        (error: HttpErrorResponse) => setValidationErrors(this.form, error),
      );
  }

  // @ts-ignore
  openWindow(url, title, options = {}): Window {
    if (typeof url === 'object') {
      options = url;
      url = '';
    }
    options = {url, title, width: 600, height: 720, ...options};

    // @ts-ignore
    const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screen.left;
    // @ts-ignore
    const dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screen.top;
    const width = window.innerWidth || document.documentElement.clientWidth || window.screen.width;
    const height = window.innerHeight || document.documentElement.clientHeight || window.screen.height;
    // @ts-ignore
    options.left = ((width / 2) - (options.width / 2)) + dualScreenLeft;
    // @ts-ignore
    options.top = ((height / 2) - (options.height / 2)) + dualScreenTop;

    const optionsStr = Object.keys(options).reduce((acc, key) => {
      // @ts-ignore
      acc.push(`${key}=${options[key]}`);
      return acc;
    }, []).join(',');

    const newWindow = window.open(url, title, optionsStr);

    // @ts-ignore
    if (window.focus) {
      // @ts-ignore
      newWindow.focus();
    }
    // @ts-ignore
    return newWindow;
  }
}
