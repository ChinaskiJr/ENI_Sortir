import { TestBed } from '@angular/core/testing';

import { StatesManagementService } from './states-management.service';

describe('StatesManagementService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: StatesManagementService = TestBed.get(StatesManagementService);
    expect(service).toBeTruthy();
  });
});
