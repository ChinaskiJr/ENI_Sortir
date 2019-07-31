import { TestBed } from '@angular/core/testing';

import { ParticipantManagementService } from './participant-management.service';

describe('ParticipantManagementService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: ParticipantManagementService = TestBed.get(ParticipantManagementService);
    expect(service).toBeTruthy();
  });
});
