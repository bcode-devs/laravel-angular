import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SocialCallbackComponent } from './social-callback.component';

describe('SocialCallbackComponent', () => {
  let component: SocialCallbackComponent;
  let fixture: ComponentFixture<SocialCallbackComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ SocialCallbackComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(SocialCallbackComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
