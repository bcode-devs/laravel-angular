import {Component, OnInit, Input} from '@angular/core';
import {AuthService} from "../../services/auth/auth.service";
import {LayoutService} from '../../services/layout.service';
import {ThemeService} from '../../services/theme.service';

import {User} from "../../models/user.model";

@Component({
  selector: 'app-header-top',
  templateUrl: './header-top.component.html'
})
export class HeaderTopComponent implements OnInit {
  layoutConf: any;
  bcodeThemes: any[] = [];
  currentLang = 'ru';
  availableLangs = [{
    name: 'Русский',
    code: 'ru',
  }, {
    name: 'English',
    code: 'en',
  }]

  @Input() user: User | any;

  constructor(
    private layout: LayoutService,
    public themeService: ThemeService,
    public authService: AuthService,
  ) {
  }

  ngOnInit() {
    this.layoutConf = this.layout.layoutConf;
    this.bcodeThemes = this.themeService.bcodeThemes;
  }

  changeTheme(theme: any) {
    this.layout.publishLayoutChange({matTheme: theme.name})
  }

  toggleSidenav() {
    if (this.layoutConf.sidebarStyle === 'closed') {
      return this.layout.publishLayoutChange({
        sidebarStyle: 'full'
      })
    }
    this.layout.publishLayoutChange({
      sidebarStyle: 'closed'
    })
  }
}
