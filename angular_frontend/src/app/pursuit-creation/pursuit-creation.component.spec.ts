import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PursuitCreationComponent } from './pursuit-creation.component';

describe('PursuitCreationComponent', () => {
  let component: PursuitCreationComponent;
  let fixture: ComponentFixture<PursuitCreationComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PursuitCreationComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PursuitCreationComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
