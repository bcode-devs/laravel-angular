import {Inject, Injectable, PLATFORM_ID} from '@angular/core';
import {isPlatformBrowser} from '@angular/common';

@Injectable({
  providedIn: 'root'
})
export class TokenStorageService {

  private jwtTokenName = 'API_TOKEN';

  constructor(
    // @ts-ignore
    @Inject(PLATFORM_ID) private platformId,
  ) {
  }

  setToken(token: string) {
    if (isPlatformBrowser(this.platformId)) {
      localStorage.setItem(this.jwtTokenName, token);
    }
  }

  getToken(): any {
    if (isPlatformBrowser(this.platformId)) {
      return localStorage.getItem(this.jwtTokenName);
    }
  }

  deleteToken() {
    if (isPlatformBrowser(this.platformId)) {
      return localStorage.removeItem(this.jwtTokenName);
    }
  }


  setAdvertViewModeToken(mode: string) {
    if (isPlatformBrowser(this.platformId)) {
      localStorage.setItem('data-view-mode', mode);
    }
  }


  setTheme(name: any) {
    if (isPlatformBrowser(this.platformId)) {
      localStorage.setItem('theme', name);
    }
  }

}
