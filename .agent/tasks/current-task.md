# Task: Fix article code block display on FE

## Scope
Ensure article detail pages render admin-authored code blocks cleanly on the public frontend without degrading inline code styling or broader article typography.

## Spec Reference
- Spec Path: None required for this targeted rendering bugfix
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
- Inspect the article detail rendering path to confirm whether `<pre><code>` markup is preserved from the API payload.
- Adjust article rich-text CSS so block code preserves formatting and scroll behavior independently from inline code styles.
- Run focused verification for the article detail page and asset compilation.

## Verification Evidence
- Command: `php artisan test tests/Feature/ArticleDetailPageTest.php`
- Result: Passed (`3` tests, `32` assertions)

- Command: `npm run build`
- Result: Passed. Vite completed successfully, with a warning that the local Node version is `22.1.0` while Vite prefers `20.19+` or `22.12+`.
