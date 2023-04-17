import { Injectable } from '@angular/core';
import { ThemeService } from './theme.service';
import { BehaviorSubject } from 'rxjs';

export interface ILayoutConf {
  navigationPos?: string; // side, top
  sidebarStyle?: string; // full, compact, closed
  sidebarCompactToggle?: boolean; // sidebar expandable on hover
  sidebarColor?: string; // Sidebar background
  dir?: string; // ltr, rtl
  isMobile?: boolean; // updated automatically
  useBreadcrumb?: boolean; // Breadcrumb enabled/disabled
  breadcrumb?: string; // simple, title
  topbarFixed?: boolean; // Fixed header
  footerFixed?: boolean; // Fixed Footer
  topbarColor?: string; // Header
  footerColor?: string; // Header
  matTheme?: string; //
  perfectScrollbar?: boolean;
}
export interface ILayoutChangeOptions {
  duration?: number;
  transitionClass?: boolean;
}
interface IAdjustScreenOptions {
  browserEvent?: any;
  route?: string;
}

@Injectable({
  providedIn: 'root',
})
export class LayoutService {
  public layoutConf: ILayoutConf = {};
  layoutConfSubject = new BehaviorSubject<ILayoutConf>(this.layoutConf);
  layoutConf$ = this.layoutConfSubject.asObservable();
  // @ts-ignore
  public isMobile: boolean;
  // @ts-ignore
  public currentRoute: string;
  public fullWidthRoutes = [];

  constructor(private themeService: ThemeService) {
    this.setAppLayout(
      // ******** SET YOUR LAYOUT OPTIONS HERE *********
      {
        navigationPos: 'top', // side, top
        sidebarStyle: 'full', // full, compact, closed
        sidebarColor: 'sidebar-black',
        sidebarCompactToggle: false, // applied when "sidebarStyle" is "compact"
        dir: 'ltr', // ltr, rtl
        useBreadcrumb: true,
        topbarFixed: false,
        footerFixed: false,
        topbarColor: 'white',
        footerColor: 'slate',
        matTheme: 'bcode-light', // bcode-navy, bcode-navy-dark
        breadcrumb: 'simple', // simple, title
        perfectScrollbar: true,
      }
    );
  }

  setAppLayout(layoutConf: ILayoutConf) {
    this.layoutConf = { ...this.layoutConf, ...layoutConf };
    this.applyMatTheme(this.layoutConf.matTheme);
  }
  // @ts-ignore
  publishLayoutChange(lc: ILayoutConf, opt: ILayoutChangeOptions = {}) {
    if (this.layoutConf.matTheme !== lc.matTheme && lc.matTheme) {
      this.themeService.changeTheme(this.layoutConf.matTheme, lc.matTheme);
    }

    this.layoutConf = Object.assign(this.layoutConf, lc);
    this.layoutConfSubject.next(this.layoutConf);
  }

  // @ts-ignore
  applyMatTheme(theme) {
    // @ts-ignore
    this.themeService.applyMatTheme(this.layoutConf.matTheme);
  }


  adjustLayout(options: IAdjustScreenOptions = {}) {
    let sidebarStyle: string;
    this.isMobile = this.isSm();
    this.currentRoute = options.route || this.currentRoute;
    sidebarStyle = this.isMobile ? 'closed' : 'full';

    if (this.currentRoute) {
      this.fullWidthRoutes.forEach((route) => {
        if (this.currentRoute.indexOf(route) !== -1) {
          sidebarStyle = 'closed';
        }
      });
    }

    this.publishLayoutChange({
      isMobile: this.isMobile,
      sidebarStyle,
    });
  }
  isSm() {
    return window.matchMedia(`(max-width: 959px)`).matches;
  }
}
