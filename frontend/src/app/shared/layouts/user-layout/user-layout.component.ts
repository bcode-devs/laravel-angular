import { Component, OnInit, AfterViewInit, HostListener, ChangeDetectorRef } from '@angular/core';
import {
  Router,
  NavigationEnd,
  RouteConfigLoadStart,
  RouteConfigLoadEnd,
  ResolveStart,
  ResolveEnd
} from '@angular/router';
import {Subject, Subscription} from "rxjs";
import { ThemeService } from '../../services/theme.service';
import { LayoutService } from '../../services/layout.service';
import {filter, takeUntil, tap} from 'rxjs/operators';

import {AuthService} from "../../services/auth/auth.service";
import {User} from "../../models/user.model";

@Component({
  selector: 'app-user-layout',
  templateUrl: './user-layout.template.html',
})
export class UserLayoutComponent implements OnInit, AfterViewInit {
  public isModuleLoading: Boolean = false;
  private moduleLoaderSub: Subscription | any;
  private layoutConfSub: Subscription | any;
  private routerEventSub: Subscription;
  private authSub: Subscription | any;

  public scrollConfig = {}
  public layoutConf: any = {};
  public adminContainerClasses: any = {};

  // User get
  private destroyedUser$ = new Subject<void>();
  private destroyed$ = new Subject<void>();
  user: User | undefined = undefined;

  loaded = false;


  constructor(
    private router: Router,
    public themeService: ThemeService,
    private layout: LayoutService,
    private cdr: ChangeDetectorRef,
    private authService: AuthService,

  ) {
    this.routerEventSub = router.events.pipe(filter(event => event instanceof NavigationEnd))

    .subscribe((routeChange: NavigationEnd | any) => {
      this.layout.adjustLayout({ route: routeChange.url });
      this.scrollToTop();
    });
  }

  ngOnInit() {
    // get auth user
    this.authSub = this.authService.user().pipe(
      takeUntil(this.destroyedUser$),
      tap(() => this.loaded = true),
    ).subscribe(user => {
      console.log(user);
      this.user = user;
      this.cdr.detectChanges();
    });

    // this.layoutConf = this.layout.layoutConf;
    this.layoutConfSub = this.layout.layoutConf$.subscribe((layoutConf) => {
        this.layoutConf = layoutConf;
        // console.log(this.layoutConf);

        this.adminContainerClasses = this.updateAdminContainerClasses(this.layoutConf);
        this.cdr.markForCheck();
    });

    // FOR MODULE LOADER FLAG
    this.moduleLoaderSub = this.router.events.subscribe(event => {
      if(event instanceof RouteConfigLoadStart || event instanceof ResolveStart) {
        this.isModuleLoading = true;
      }
      if(event instanceof RouteConfigLoadEnd || event instanceof ResolveEnd) {
        this.isModuleLoading = false;
      }
    });
  }
  @HostListener('window:resize', ['$event'])
  // @ts-ignore
  onResize(event) {
    this.layout.adjustLayout(event);
  }

  ngAfterViewInit() {

  }

  scrollToTop() {
    if(document) {
      setTimeout(() => {
        let element;
        if(this.layoutConf.topbarFixed) {
          element = <HTMLElement>document.querySelector('#rightside-content-hold');
        } else {
          element = <HTMLElement>document.querySelector('#main-content-wrap');
        }
        element.scrollTop = 0;
      })
    }
  }
  ngOnDestroy() {
    if(this.moduleLoaderSub) {
      this.moduleLoaderSub.unsubscribe();
    }
    if(this.layoutConfSub) {
      this.layoutConfSub.unsubscribe();
    }
    if(this.routerEventSub) {
      this.routerEventSub.unsubscribe();
    }
    if (this.authSub) {
      this.authSub.unsubscribe();
    }
    this.destroyed$.next();
    this.destroyed$.complete();
  }
  closeSidebar() {
    this.layout.publishLayoutChange({
      sidebarStyle: 'closed'
    })
  }
  // @ts-ignore
  sidebarMouseenter(e) {
    // console.log(this.layoutConf);
    if(this.layoutConf.sidebarStyle === 'compact') {
        this.layout.publishLayoutChange({sidebarStyle: 'full'}, {transitionClass: true});
    }
  }

  // @ts-ignore
  sidebarMouseleave(e) {
    // console.log(this.layoutConf);
    if (
        this.layoutConf.sidebarStyle === 'full' &&
        this.layoutConf.sidebarCompactToggle
    ) {
        this.layout.publishLayoutChange({sidebarStyle: 'compact'}, {transitionClass: true});
    }
  }

  // @ts-ignore
  updateAdminContainerClasses(layoutConf) {
    return {
      'navigation-top': layoutConf.navigationPos === 'top',
      'sidebar-full': layoutConf.sidebarStyle === 'full',
      'sidebar-compact': layoutConf.sidebarStyle === 'compact' && layoutConf.navigationPos === 'side',
      'compact-toggle-active': layoutConf.sidebarCompactToggle,
      'sidebar-compact-big': layoutConf.sidebarStyle === 'compact-big' && layoutConf.navigationPos === 'side',
      'sidebar-opened': layoutConf.sidebarStyle !== 'closed' && layoutConf.navigationPos === 'side',
      'sidebar-closed': layoutConf.sidebarStyle === 'closed',
      'fixed-topbar': layoutConf.topbarFixed && layoutConf.navigationPos === 'side'
    }
  }

}
