import {FlexModule} from "@angular/flex-layout";
import {ReactiveFormsModule} from "@angular/forms";
import {CommonModule} from '@angular/common';
import {RouterLink} from "@angular/router";
import {NgModule} from '@angular/core';

import {SocialCallbackComponent} from "./page/social-callback/social-callback.component";
import { ResetPasswordComponent } from './page/reset-password/reset-password.component';
import {SharedMaterialModule} from "../../shared/shared-material.module";
import {SignUpComponent} from './page/sign-up/sign-up.component';
import {SignInComponent} from './page/sign-in/sign-in.component';
import {VerifyComponent} from './page/verify/verify.component';
import {SharedModule} from "../../shared/shared.module";
import {AuthRoutingModule} from "./auth-routing.module";
import {MatSnackBarModule} from "@angular/material/snack-bar";


@NgModule({
  declarations: [
    SocialCallbackComponent,
    ResetPasswordComponent,
    SignInComponent,
    SignUpComponent,
    VerifyComponent,
  ],
  imports: [
    SharedMaterialModule,
    ReactiveFormsModule,
    AuthRoutingModule,
    MatSnackBarModule,
    SharedModule,
    CommonModule,
    RouterLink,
    FlexModule
  ]
})
export class AuthModule {
}
