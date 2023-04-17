import {CommonModule} from '@angular/common';
import {NgModule} from '@angular/core';

// SERVICES
import {RoutePartsService} from './services/route-parts.service';
import {ThemeService} from './services/theme.service';
import {AuthGuard} from './guards/auth.guard';

import {SharedComponentsModule} from './components/shared-components.module';
import {SharedDirectivesModule} from './directives/shared-directives.module';
import {SharedPipesModule} from './pipes/shared-pipes.module';


@NgModule({
  imports: [
    SharedDirectivesModule,
    SharedComponentsModule,
    SharedPipesModule,
    CommonModule,

  ],
  providers: [
    RoutePartsService,
    ThemeService,
    AuthGuard
  ],
  exports: [
    SharedDirectivesModule,
    SharedComponentsModule,
    SharedPipesModule
  ]
})
export class SharedModule {
}
