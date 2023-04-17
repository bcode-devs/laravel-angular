import { ComponentFixture, TestBed, waitForAsync } from '@angular/core/testing';

import { BcodeSidebarComponent } from './bcode-sidebar.component';

describe('BcodeSidebarComponent', () => {
  let component: BcodeSidebarComponent;
  let fixture: ComponentFixture<BcodeSidebarComponent>;

  beforeEach(waitForAsync(() => {
    TestBed.configureTestingModule({
      declarations: [ BcodeSidebarComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(BcodeSidebarComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
