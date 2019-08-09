import { TestBed } from '@angular/core/testing';

import { LoginManagementService } from './login-management.service';

describe('LoginManagementService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: LoginManagementService = TestBed.get(LoginManagementService);
    expect(service).toBeTruthy();
  });
});
