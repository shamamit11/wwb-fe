# Task: Rebuild article detail around structured content blocks

## Scope
Use article `blocks` as the primary rendering source for the detail page, clean malformed markdown such as `## ##`, and apply intentional UI treatment per supported block type (`heading`, `paragraph`, `faq`).

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
- Normalize the service payload block content before rendering, including malformed repeated markdown heading markers.
- Build editorial sections from `heading` + `paragraph` blocks and render `faq` blocks separately as expandable panels.
- Refresh the article detail Blade/CSS so structured blocks present as designed sections instead of one flat markdown column.

## Verification Evidence
- Command: `php -l app/Livewire/ArticleDetailPage.php`
- Result: Passed, no syntax errors detected
- Command: `php artisan test tests/Feature/ArticleDetailPageTest.php`
- Result: Passed, 3 tests / 30 assertions
- Command: `npm run build`
- Result: Build completed successfully and emitted assets; Vite warned that the local Node version is `22.1.0` while it prefers `20.19+` or `22.12+`.
