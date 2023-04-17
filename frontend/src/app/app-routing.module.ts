import {RouterModule, Routes} from '@angular/router';
import {NgModule} from '@angular/core';

import {UserLayoutComponent} from "./shared/layouts/user-layout/user-layout.component";
import {AuthLayoutComponent} from "./shared/layouts/auth-layout/auth-layout.component";
import {AuthGuard} from "./shared/guards/auth.guard";

const routes: Routes = [
  {
    path: '',
    component: UserLayoutComponent,
    canActivate: [AuthGuard],
    children: [
      {
        path: '',
        loadChildren: () => import('./modules/main/main.module').then(m => m.MainModule),
        data: {title: 'Main module', breadcrumb: 'main page'}
      },
    ]
  },
  {
    path: '',
    component: AuthLayoutComponent,
    children: [
      {
        path: 'auth',
        loadChildren: () => import('./modules/auth/auth.module').then(m => m.AuthModule),
        data: {title: 'Войдите в ваш аккаунт', breadcrumb: 'Войти'}
      },
    ]
  },
];

@NgModule({
  imports: [RouterModule.forRoot(routes, {
    initialNavigation: 'enabledBlocking',
    useHash: false
  })],
  exports: [RouterModule]
})
export class AppRoutingModule {
}
