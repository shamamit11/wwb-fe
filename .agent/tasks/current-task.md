# Task: Rewrite service-host SEO URLs to the public site origin

## Scope
Prevent article SEO metadata and JSON-LD from exposing `service.widewebblog.com` by rewriting service-host URLs to the frontend site origin before rendering.

## Spec Reference
- Spec Path: `.agent/specs/active/public-posts-api.md`
- Requirement IDs: `PP-2`
- Acceptance Criteria IDs: `AC-3`

## Checklist
- [x] Confirm spec or draft one if required
- [x] Research the minimal file set
- [x] Record implementation plan
- [x] Implement focused changes
- [x] Run verification
- [x] Update docs or manifest if stable conventions changed

## Plan
- Add one helper that rewrites URLs from the configured service host to the frontend/public site origin.
- Apply it to article canonical URLs and recursively through article schema payloads before they are sent to the SEO component.
- Add focused feature coverage proving service-host schema/canonical URLs are normalized in the rendered page.

## Verification Evidence
- Command: `php -l app/Support/PublicSiteUrl.php`
- Result: Passed, no syntax errors detected
- Command: `php artisan test tests/Feature/ArticleDetailPageTest.php`
- Result: Passed, 3 tests / 35 assertions
