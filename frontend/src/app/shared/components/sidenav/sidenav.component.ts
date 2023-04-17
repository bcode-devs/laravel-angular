import { Component, OnInit, Input, ViewChild, ElementRef } from '@angular/core';

@Component({
  selector: 'app-sidenav',
  templateUrl: './sidenav.template.html'
})
export class SidenavComponent {

  // @ts-ignore
  @Input('hasIconMenu') public hasIconTypeMenuItem: boolean;
  // @ts-ignore
  @Input('iconMenuTitle') public iconTypeMenuTitle: string;
  // @ts-ignore
  @ViewChild('sidenav') sidenav:ElementRef;

  constructor() {}
  ngOnInit() {}
  ngAfterViewInit() {

  }

}
