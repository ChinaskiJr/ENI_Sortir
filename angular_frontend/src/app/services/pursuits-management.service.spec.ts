import { TestBed } from '@angular/core/testing';

import { PursuitsManagementService } from './pursuits-management.service';

describe('PursuitsManagementService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: PursuitsManagementService = TestBed.get(PursuitsManagementService);
    expect(service).toBeTruthy();
  });
});
