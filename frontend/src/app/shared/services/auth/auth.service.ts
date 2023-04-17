import {flatMap, map, publishReplay, refCount, tap} from 'rxjs/operators';
import {BehaviorSubject, Observable, of as observableOf} from 'rxjs';
import {Injectable} from '@angular/core';

import {TokenStorageService} from '../token-storage.service';

import {AuthResponse, User} from "../../models/user.model";
import {ApiService} from '../api.service';

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  private user$: BehaviorSubject<User | undefined> = new BehaviorSubject<User | undefined>(undefined);
  private loadUser$ = this.loadUser().pipe(publishReplay(), refCount());

  public jwtTokenName = 'API_TOKEN';

  constructor(
    private api: ApiService,
    private tokenStorageService: TokenStorageService
  ) {
  }

  user() {
    return this.loadUser$.pipe(flatMap(() => this.user$.asObservable()));
  }

  loadUser(): Observable<User> {
    // @ts-ignore
    if (!this.tokenStorageService.getToken()) {
      // @ts-ignore
      return observableOf(undefined);
    }
    return this.api.get('profile/info').pipe(
      map(response => response.data),
      tap((user: User) => {
        this.user$.next(user)
      }),
    );
  }

  setUser(user: User) {
    this.user$.next(user);
  }

  register(registerForm: SignUpForm): Observable<AuthResponse> {
    return this.api.post('auth/sign-up', registerForm)
      .pipe(
        map(response => response),
        tap((auth: AuthResponse) => this.user$.next(auth.user))
      );
  }

  verifyEmailToken(token: string): Observable<AuthResponse> {
    return this.api.post('auth/verify-email/', {token})
      .pipe(
        map(response => response),
        tap((auth: AuthResponse) => this.user$.next(auth.user))
      );
  }

  resetPassword(resetForm: SignInForm): Observable<AuthResponse> {
    return this.api.post('auth/reset/password', resetForm)
      .pipe(
        map(response => response)
      );
  }

  signIn(signInForm: SignInForm): Observable<User> {
    return this.api.post('auth/sign-in', signInForm).pipe(
      map(response => {
        this.tokenStorageService.setToken(response.token)
        return response.data
      }),
      tap((user: User) => this.user$.next(user)),
    );
  }


  resetSendMail(signInForm: SignInForm): Observable<AuthResponse> {
    return this.api.post('auth/reset/email', signInForm).pipe(
      map(response => response.data),
    );
  }

  userUpdate(UserUpdateForm: UserUpdateForm) {
    return this.api.post('account/profile', UserUpdateForm).pipe(
      map(response => response.data),
      tap((auth: AuthResponse) => {
        this.user$.next(auth.user);
      }),
    );
  }

  userPasswordUpdate(UserPasswordUpdateForm: UserPasswordUpdateForm) {
    return this.api.post('account/password', UserPasswordUpdateForm).pipe(
      map(response => response.data)
    );
  }

  signInSocial(): Observable<AuthResponse> {
    return this.api.get('profile/info').pipe(
      map(response => response.data),
      tap((auth: AuthResponse) => this.user$.next(auth.user)),
    );
  }

  githubFacebook() {
    return this.api.post('auth/oauth/facebook', {}).pipe(
      map(data => data.url),
    );
  }

  googleLogin() {
    return this.api.post('auth/oauth/google', {}).pipe(
      map(data => data.url)
    );
  }

  signOut() {
    this.tokenStorageService.deleteToken();
    // @ts-ignore
    this.user$.next(undefined);
  }

}

export interface UserUpdateForm {
  name: string;
}

export interface UserPasswordUpdateForm {
  password: string;
  password_confirmation: string;
}


export interface SignUpForm {
  email: string;
  password: string;
  password_confirmation: string;
}


export interface SignInForm {
  email: string;
  password: string;
}
