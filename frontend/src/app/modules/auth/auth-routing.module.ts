import {RouterModule, Routes} from '@angular/router';
import {NgModule} from '@angular/core';

import {SocialCallbackComponent} from "./page/social-callback/social-callback.component";
import {ResetPasswordComponent} from "./page/reset-password/reset-password.component";
import {SignInComponent} from "./page/sign-in/sign-in.component";
import {SignUpComponent} from "./page/sign-up/sign-up.component";
import {VerifyComponent} from "./page/verify/verify.component";

const routes: Routes = [
  {
    path: 'sign-in',
    component: SignInComponent,
  },
  {
    path: 'sign-up',
    component: SignUpComponent,
  },
  {
    path: 'verify',
    component: VerifyComponent,
  },
  {
    path: 'social-callback',
    component: SocialCallbackComponent
  },
  {
    path: 'reset-password',
    component: ResetPasswordComponent
  }

];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class AuthRoutingModule {
}
