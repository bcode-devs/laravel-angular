import {
  Component,
  OnInit,
  Input,
  HostBinding,
  OnDestroy,
  HostListener,
  Directive,
  Renderer2,
  ElementRef,
  ChangeDetectorRef
} from "@angular/core";
import {MatchMediaService} from "../../services/match-media.service";
import {MediaObserver} from "@angular/flex-layout";
import {Subject} from "rxjs";
import {takeUntil} from "rxjs/operators";
import {BcodeSidebarHelperService} from "./bcode-sidebar-helper.service";

@Component({
  selector: "bcode-sidebar",
  templateUrl: "./bcode-sidebar.component.html",
  styleUrls: ["./bcode-sidebar.component.scss"]
})
export class BcodeSidebarComponent implements OnInit, OnDestroy {
  // Name
  @Input()
  // @ts-ignore
  name: string;

  // right
  @Input()
  @HostBinding("class.position-right")
  // @ts-ignore
  right: boolean;

  // Open
  @HostBinding("class.open")
  // @ts-ignore
  opened: boolean;

  @HostBinding("class.sidebar-locked-open")
  // @ts-ignore
  sidebarLockedOpen: boolean;

  //mode
  @HostBinding("class.is-over")
    // @ts-ignore
  isOver: boolean;

  private backdrop: HTMLElement | null = null;

  private lockedBreakpoint = "gt-sm";
  private unsubscribeAll: Subject<any>;

  constructor(
    private matchMediaService: MatchMediaService,
    private mediaObserver: MediaObserver,
    private sidebarHelperService: BcodeSidebarHelperService,
    private _renderer: Renderer2,
    private _elementRef: ElementRef,
    private cdr: ChangeDetectorRef
  ) {
    this.unsubscribeAll = new Subject();
  }

  ngOnInit() {
    this.sidebarHelperService.setSidebar(this.name, this);

    if (this.mediaObserver.isActive(this.lockedBreakpoint)) {
      this.sidebarLockedOpen = true;
      this.opened = true;
    } else {
      this.sidebarLockedOpen = false;
      this.opened = false;
    }

    this.matchMediaService.onMediaChange
      .pipe(takeUntil(this.unsubscribeAll))
      .subscribe(() => {
        // console.log("medua sub");
        if (this.mediaObserver.isActive(this.lockedBreakpoint)) {
          this.sidebarLockedOpen = true;
          this.opened = true;
        } else {
          this.sidebarLockedOpen = false;
          this.opened = false;
        }
      });
  }

  open() {
    this.opened = true;
    if (!this.sidebarLockedOpen && !this.backdrop) {
      this.showBackdrop();
    }
  }

  close() {
    this.opened = false;
    this.hideBackdrop();
  }

  toggle() {
    if (this.opened) {
      this.close();
    } else {
      this.open();
    }
  }

  showBackdrop() {
    this.backdrop = this._renderer.createElement("div");
    // @ts-ignore
    this.backdrop.classList.add("bcode-sidebar-overlay");

    this._renderer.appendChild(
      this._elementRef.nativeElement.parentElement,
      this.backdrop
    );

    // Close sidebar onclick
    // @ts-ignore
    this.backdrop.addEventListener("click", () => {
      this.close();
    });

    this.cdr.markForCheck();
  }

  hideBackdrop() {
    if (this.backdrop) {
      // @ts-ignore
      this.backdrop.parentNode.removeChild(this.backdrop);
      this.backdrop = null;
    }

    this.cdr.markForCheck();
  }

  ngOnDestroy(): void {
    this.unsubscribeAll.next(1);
    this.unsubscribeAll.complete();
    this.sidebarHelperService.removeSidebar(this.name);
  }
}

@Directive({
  selector: "[bcodeSidebarToggler]"
})
export class BcodeSidebarTogglerDirective {
  @Input("bcodeSidebarToggler")
  public id: any;

  constructor(private bcodeSidebarHelperService: BcodeSidebarHelperService) {
  }

  @HostListener("click")
  onClick() {
    this.bcodeSidebarHelperService.getSidebar(this.id).toggle();
  }
}
