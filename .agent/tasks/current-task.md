# Task: Improve article detail heading hierarchy

## Scope
Refine the article detail page semantics so the structured content follows a cleaner heading hierarchy with `h1`, `h2`, and `h3` tags.

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
- Render structured section titles with their mapped heading level.
- Promote FAQ question labels to semantic `h3` headings inside the accordion summary.
- Run the focused article detail feature test after the markup change.

## Verification Evidence
- Command: `php artisan test tests/Feature/ArticleDetailPageTest.php`
- Result: Passed, 3 tests / 36 assertions
