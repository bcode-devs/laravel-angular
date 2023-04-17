import { Injectable, Inject, Renderer2, RendererFactory2, EventEmitter } from '@angular/core';
import { DOCUMENT } from '@angular/common';

export interface ITheme {
  name: string,
  baseColor?: string,
  isActive?: boolean
}

@Injectable()
export class ThemeService {
  public onThemeChange: EventEmitter<ITheme> = new EventEmitter();

  public bcodeThemes: ITheme[]  = [
  {
    'name': 'bcode-light',
    'baseColor': '#b1b2b7',
    'isActive': false
  },
  {
    'name': 'bcode-dark',
    'baseColor': '#181a21',
    'isActive': false
  }];

  // @ts-ignore
  public activatedTheme: ITheme;
  private renderer: Renderer2;
  constructor(
    @Inject(DOCUMENT) private document: Document,
    rendererFactory: RendererFactory2
  ) {
    this.renderer = rendererFactory.createRenderer(null, null);
  }

  // Invoked in AppComponent and apply 'activatedTheme' on startup
  applyMatTheme( themeName: string | undefined) {
    if (themeName) {
      // @ts-ignore
      this.activatedTheme = this.bcodeThemes.find(t => t.name === themeName);
      this.flipActiveFlag(themeName);

      // this.changeTheme(themeName);
      this.renderer.addClass(this.document.body, themeName);
    }
  }

  // @ts-ignore
  changeTheme(prevTheme, themeName: string) {
    this.renderer.removeClass(this.document.body, prevTheme);
    this.renderer.addClass(this.document.body, themeName);
    this.flipActiveFlag(themeName);
    this.onThemeChange.emit(this.activatedTheme);
  }

  flipActiveFlag(themeName: string) {
    this.bcodeThemes.forEach((t) => {
      t.isActive = false;
      if (t.name === themeName) {
        t.isActive = true;
        this.activatedTheme = t;
      }
    });
  }
}
