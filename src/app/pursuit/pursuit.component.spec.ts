import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PursuitComponent } from './pursuit.component';

describe('PursuitComponent', () => {
  let component: PursuitComponent;
  let fixture: ComponentFixture<PursuitComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PursuitComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PursuitComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
