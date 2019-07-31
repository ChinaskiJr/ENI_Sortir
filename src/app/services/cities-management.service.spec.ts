import { TestBed } from '@angular/core/testing';

import { CitiesManagementService } from './cities-management.service';

describe('CitiesManagementService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: CitiesManagementService = TestBed.get(CitiesManagementService);
    expect(service).toBeTruthy();
  });
});
