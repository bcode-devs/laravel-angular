import { SharedMaterialModule } from '../shared-material.module';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { NgModule } from '@angular/core';

import { SharedDirectivesModule } from '../directives/shared-directives.module';
import { SharedPipesModule } from '../pipes/shared-pipes.module';
import { FlexLayoutModule } from '@angular/flex-layout';


// **TOP** NAVIGATION LAYOUT
import { HeaderTopComponent } from './header-top/header-top.component';
import { SidebarTopComponent } from './sidebar-top/sidebar-top.component';


// ALWAYS REQUIRED
import { SidenavComponent } from './sidenav/sidenav.component';
import { FooterComponent } from './footer/footer.component';
import { BreadcrumbComponent } from './breadcrumb/breadcrumb.component';
import { BcodeSidebarComponent, BcodeSidebarTogglerDirective } from './bcode-sidebar/bcode-sidebar.component';

import {AuthLayoutComponent} from "../layouts/auth-layout/auth-layout.component";
import {UserLayoutComponent} from "../layouts/user-layout/user-layout.component";

const components = [
  HeaderTopComponent,
  SidebarTopComponent,
  SidenavComponent,
  AuthLayoutComponent,
  UserLayoutComponent,
  BreadcrumbComponent,
  BcodeSidebarComponent,
  FooterComponent,
  BcodeSidebarTogglerDirective,
]

@NgModule({
  imports: [
CommonModule,
    FormsModule,
    RouterModule,
    FlexLayoutModule,
    SharedPipesModule,
    SharedDirectivesModule,
    SharedMaterialModule
  ],
  declarations: components,
  exports: components
})
export class SharedComponentsModule {}
