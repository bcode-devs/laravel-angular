import {Component, Inject, OnDestroy, OnInit, PLATFORM_ID} from '@angular/core';
import {ActivatedRoute, Router} from "@angular/router";
import {isPlatformBrowser} from "@angular/common";
import {Subscription} from "rxjs";

import {TokenStorageService} from "../../../../shared/services/token-storage.service";

@Component({
  selector: 'app-social-callback',
  templateUrl: './social-callback.component.html',
  styleUrls: ['./social-callback.component.scss']
})
export class SocialCallbackComponent implements OnInit, OnDestroy {
  // @ts-ignore
  queryToken: string;
  // @ts-ignore
  public sub: Subscription;

  constructor(
    private router: Router,
    private tokenStorageService: TokenStorageService,
    private route: ActivatedRoute,
    private tokenStorage: TokenStorageService,
    // @ts-ignore
    @Inject(PLATFORM_ID) private platformId,
  ) {
  }

  ngOnInit() {
    if (isPlatformBrowser(this.platformId)) {
      this.sub = this.route.queryParams.subscribe(params => {
        this.queryToken = params['token'];
        this.tokenStorage.setToken(this.queryToken);
        window.opener.postMessage({token: 'ok'}, '/');
        window.close();
      });
    }
  }

  ngOnDestroy(): void {
    if (this.sub) {
      this.sub.unsubscribe();
    }
  }
}
