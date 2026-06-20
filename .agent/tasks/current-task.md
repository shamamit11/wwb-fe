# Task: Resolve service-hosted media URLs to the media origin

## Scope
Fix frontend media URL normalization so relative media paths from the service API resolve to the media origin instead of the API/service origin.

## Spec Reference
- Spec Path: `.agent/specs/active/public-posts-api.md`
- Requirement IDs: `PP-1`, `PP-2`, `PP-3`
- Acceptance Criteria IDs: `AC-1`, `AC-3`, `AC-4`

## Checklist
- [x] Confirm spec or draft one if required
- [x] Research the minimal file set
- [x] Record implementation plan
- [x] Implement focused changes
- [x] Run verification
- [x] Update docs or manifest if stable conventions changed

## Plan
- Introduce one shared media URL resolver for relative service payload paths.
- Prefer an explicit media base URL config when present, otherwise derive the media origin from the service API host.
- Replace page-local media URL normalization in homepage, article detail, archive/search mappings, and article SEO metadata.
- Update focused feature tests to assert relative media paths render against the media origin.

## Verification Evidence
- Command: `php artisan test tests/Feature/HomePageTest.php tests/Feature/ArticleDetailPageTest.php tests/Feature/AllArticlesPageTest.php tests/Feature/SearchPageTest.php tests/Feature/AboutPageTest.php`
- Acceptance Criteria Proven: `AC-1`, `AC-3`, and `AC-4` still render service-backed content while relative media paths now resolve to the media origin instead of the service/API origin.
- Result: Passed, 23 tests / 149 assertions
