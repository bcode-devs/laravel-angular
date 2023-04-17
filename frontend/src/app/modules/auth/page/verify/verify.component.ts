import {Component, Inject, OnDestroy, OnInit, PLATFORM_ID} from '@angular/core';
import {ActivatedRoute, Router} from "@angular/router";
import {HttpErrorResponse} from "@angular/common/http";
import {isPlatformBrowser} from "@angular/common";
import {first, Subscription} from "rxjs";
import {tap} from "rxjs/operators";

import {TokenStorageService} from "../../../../shared/services/token-storage.service";
import {AuthService} from "../../../../shared/services/auth/auth.service";
import {MatSnackBar} from "@angular/material/snack-bar";


@Component({
  selector: 'app-verify',
  templateUrl: './verify.component.html',
  styleUrls: ['./verify.component.scss']
})
export class VerifyComponent implements OnInit, OnDestroy {


  public emailVerified: boolean
  private sub: Subscription | undefined;
  private queryToken: string | undefined;

  constructor(
    private router: Router,
    private tokenStorageService: TokenStorageService,
    private route: ActivatedRoute,
    private tokenStorage: TokenStorageService,
    private authService: AuthService,
    private _snackBar: MatSnackBar,
    // @ts-ignore
    @Inject(PLATFORM_ID) private platformId,
  ) {
    this.emailVerified = false;
  }

  ngOnInit() {
    if (isPlatformBrowser(this.platformId)) {
      this.sub = this.route.queryParams.subscribe(params => {
        this.queryToken = params['token']
        if (this.queryToken) {
          this.authService.verifyEmailToken(this.queryToken)
            .pipe(
              first(),
              tap(() => {
              }, () => {
              }),
            )
            .subscribe(
              () => this.emailVerified = true,
              (error: HttpErrorResponse) => this.openSnackBar(error.error.message, '')
            );
        }

      });
    }
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
