# Task: Make articles archive the homepage

## Scope
Use the articles archive as the homepage, keep the newsletter signup section on that archive, repoint the shared header Subscribe CTA to the homepage newsletter anchor, comment out the direct `/articles` archive route for now, remove `All Articles` from navigation, hydrate the root archive SEO, header copy, and newsletter copy from the public homepage endpoint, and update the shared site branding to use the SVG logo with a logo-aligned color palette.

## Spec Reference
- Spec Path: `.agent/specs/active/public-posts-api.md`
- Requirement IDs: PP-1
- Acceptance Criteria IDs: AC-1

## Checklist
- [x] Confirm spec or draft one if required
- [x] Research the minimal file set
- [x] Record implementation plan
- [x] Implement focused changes
- [x] Run verification
- [x] Update docs or manifest if stable conventions changed

## Plan
- Add newsletter state and subscribe handling to `AllArticlesPage` using the existing public newsletter endpoint flow.
- Render the newsletter section with `id="newsletter"` at the bottom of the articles archive page.
- Point the shared header Subscribe CTA to the homepage newsletter anchor.
- Route `/` to the articles archive and comment out the direct `/articles` route.
- Remove `All Articles` from shared navigation.
- Source root-archive SEO from homepage `data.seo`, archive header title/description from homepage `data.hero`, and newsletter title/description from homepage `data.newsletter_section`.
- Replace the text badge brand mark with `public/images/wide-web-blog-icon.svg` and shift shared accent/ink colors toward the logo palette.
- Run focused feature tests for articles, shared header CTA, and newsletter submission behavior.

## Verification Evidence
- Command: `php artisan test tests/Feature/AllArticlesPageTest.php`
- Acceptance Criteria Proven: AC-1
- Result: Passed (`7` tests, `34` assertions)

- Command: `php artisan test tests/Feature/AboutPageTest.php`
- Acceptance Criteria Proven: AC-1
- Result: Passed (`4` tests, `18` assertions)

- Command: `php artisan test tests/Feature/AllArticlesPageTest.php tests/Feature/AboutPageTest.php`
- Acceptance Criteria Proven: AC-1
- Result: Passed (`11` tests, `52` assertions)

- Command: `php artisan test tests/Feature/AllArticlesPageTest.php tests/Feature/AboutPageTest.php`
- Acceptance Criteria Proven: AC-1
- Result: Passed (`11` tests, `57` assertions)

- Command: `php artisan test tests/Feature/HomePageTest.php`
- Acceptance Criteria Proven: AC-1
- Result: Passed (`8` tests, `48` assertions)

- Command: `php artisan test tests/Feature/HomePageTest.php tests/Feature/AboutPageTest.php`
- Acceptance Criteria Proven: AC-1
- Result: Passed (`12` tests, `66` assertions)
