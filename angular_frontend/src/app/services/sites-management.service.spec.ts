import { TestBed } from '@angular/core/testing';

import { SitesManagementService } from './sites-management.service';

describe('SitesManagementService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: SitesManagementService = TestBed.get(SitesManagementService);
    expect(service).toBeTruthy();
  });
});
