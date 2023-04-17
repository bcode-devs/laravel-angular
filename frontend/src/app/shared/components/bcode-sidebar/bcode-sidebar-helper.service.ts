import { Injectable } from "@angular/core";
import { BcodeSidebarComponent } from "./bcode-sidebar.component";

@Injectable({
  providedIn: "root"
})
export class BcodeSidebarHelperService {
  sidebarList: BcodeSidebarComponent[];

  constructor() {
    this.sidebarList = [];
  }

  // @ts-ignore
  setSidebar(name, sidebar): void {
    this.sidebarList[name] = sidebar;
  }

  // @ts-ignore
  getSidebar(name): any {
    return this.sidebarList[name];
  }

  // @ts-ignore
  removeSidebar(name) {
    if (!this.sidebarList[name]) {
      console.warn(`The sidebar with name '${name}' doesn't exist.`);
    }

    // remove sidebar
    delete this.sidebarList[name];
  }
}
