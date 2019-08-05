import { TestBed } from '@angular/core/testing';

import { RegistrationsManagementService } from './registrations-management.service';

describe('RegistrationsManagementService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: RegistrationsManagementService = TestBed.get(RegistrationsManagementService);
    expect(service).toBeTruthy();
  });
});
