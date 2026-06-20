# Task: Fix RSS feed URL rendering

## Scope
Make the frontend RSS feed and its footer link render against the current request host instead of the configured production app URL.

## Spec Reference
- Spec Path: none
- Requirement IDs: none
- Acceptance Criteria IDs: none

## Checklist
- [x] Confirm spec or draft one if required
- [x] Research the minimal file set
- [x] Record implementation plan
- [x] Implement focused changes
- [x] Run verification
- [ ] Update docs or manifest if stable conventions changed

## Plan
- Remove the RSS Blade rendering path and return XML directly from the controller.
- Normalize item links from the service host onto the public site host.
- Update the footer RSS link to use the same request-aware route.
- Run the focused RSS feature test and record the result.

## Verification Evidence
- Command: `php artisan test tests/Feature/RssFeedTest.php`
- Result: Passed, 2 tests / 15 assertions
- Command: `php artisan test tests/Feature/HomePageTest.php --filter=footer`
- Result: Passed, 1 test / 8 assertions
