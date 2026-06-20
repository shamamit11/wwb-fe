# Task: Fix shared subscribe navigation target

## Scope
Make the shared header Subscribe action navigate to a real newsletter section from any page instead of using a page-local `#newsletter` anchor that fails on routes like `/about`.

## Spec Reference
- Spec Path: No active spec; implementing directly from the reported navigation bug and current frontend routing behavior.
- Requirement IDs: N/A
- Acceptance Criteria IDs: N/A

## Checklist
- [x] Confirm spec or draft one if required
- [x] Research the minimal file set
- [x] Record implementation plan
- [x] Implement focused changes
- [x] Run verification
- [x] Update docs or manifest if stable conventions changed

## Plan
- Replace the shared header CTA `#newsletter` hash with a route-qualified homepage newsletter anchor.
- Add a focused feature assertion that the About page renders the shared Subscribe CTA pointing to the homepage newsletter section.

## Verification Evidence
- Command: `php artisan test tests/Feature/AboutPageTest.php`
- Acceptance Criteria Proven: The shared Subscribe CTA now targets the homepage newsletter anchor from the About page instead of a broken page-local hash.
- Result: Passed, 4 tests / 16 assertions
