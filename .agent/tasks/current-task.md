# Task: Align Public Homepage With Homepage Admin Payload

## Scope
Update the public homepage so it can render against the managed homepage section model exposed by the service, using the structured hero, featured editorial, guide, topic, promo, newsletter, and SEO fields with safe fallback content when upstream data is unavailable or partial.

## Spec Reference
- Spec Path: No active spec; implementing directly from the provided homepage payload contract and documented `/public/home` + `/admin/homepage` resources.
- Requirement IDs: N/A
- Acceptance Criteria IDs: N/A

## Checklist
- [x] Confirm spec or draft one if required
- [x] Research the minimal file set
- [x] Record implementation plan
- [x] Implement focused changes
- [x] Run verification
- [x] Update docs or manifest if stable conventions changed

## Verification Evidence
- Command: `php -l app/Livewire/HomePage.php && php -l routes/web.php && php -l resources/views/home.blade.php` and `php artisan test tests/Feature/HomePageTest.php tests/Unit/BlogContentServiceTest.php`
- Acceptance Criteria Proven: Homepage renders fallback content safely, renders managed homepage sections when service payload is present, and outputs homepage SEO metadata from the managed payload.
- Result: Passed
