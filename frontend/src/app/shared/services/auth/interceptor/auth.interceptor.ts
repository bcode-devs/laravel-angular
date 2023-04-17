import { HttpErrorResponse, HttpEvent, HttpHandler, HttpInterceptor, HttpRequest, HttpResponse } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { tap } from 'rxjs/operators';
import { Observable } from 'rxjs';
import {TokenStorageService} from '../../token-storage.service';


@Injectable()
export class AuthInterceptor implements HttpInterceptor {

  private apiTokenName = 'Api-Token';

  constructor(
    private tokenStorage: TokenStorageService,
    private router: Router,
  ) {
  }

  intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    const token = this.tokenStorage.getToken();

    if (token) {
      req = req.clone({setHeaders: {Authorization: `Bearer ${token}`}});
    }

    return next.handle(req).pipe(
      // @ts-ignore
      tap(
        (response: HttpResponse<any>) => {
          if (response.headers && response.headers.get(this.apiTokenName)) {
            // @ts-ignore
            this.tokenStorage.setToken(response.headers.get(this.apiTokenName));
          }
        },
        (error: HttpErrorResponse) => {
          if (error.status === 401) {
            this.router.navigateByUrl('/');
          }
        },
      ),
    );
  }
}
