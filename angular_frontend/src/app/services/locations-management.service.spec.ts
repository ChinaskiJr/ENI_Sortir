import { TestBed } from '@angular/core/testing';

import { LocationsManagementService } from './locations-management.service';

describe('LocationsManagementService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: LocationsManagementService = TestBed.get(LocationsManagementService);
    expect(service).toBeTruthy();
  });
});
