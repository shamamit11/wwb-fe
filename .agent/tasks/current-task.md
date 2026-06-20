# Task: Legal pages hydrate from public pages API

## Scope
Replace hardcoded Privacy Policy and Terms and Conditions page copy with API-backed content from the public pages endpoint while keeping the existing frontend routes and shared legal layout.

## Spec Reference
- Spec Path: `.agent/specs/active/legal-pages-api.md`
- Requirement IDs: LP-1, LP-2, LP-3, LP-4
- Acceptance Criteria IDs: AC-1, AC-2, AC-3, AC-4

## Checklist
- [x] Confirm spec or draft one if required
- [x] Research the minimal file set
- [x] Record implementation plan
- [x] Implement focused changes
- [x] Run verification
- [x] Update docs or manifest if stable conventions changed

## Verification Evidence
- Command: `php artisan test tests/Feature/LegalPagesTest.php`
- Acceptance Criteria Proven: AC-1, AC-2, AC-3
- Result: Passed, 3 tests / 13 assertions
- Command: `php artisan test tests/Unit/BlogContentServiceTest.php`
- Acceptance Criteria Proven: AC-4
- Result: Passed, 5 tests / 17 assertions
