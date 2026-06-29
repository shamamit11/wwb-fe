# Task: Improve AI/search discoverability surfaces

## Scope
Implement the agreed technical discoverability improvements only: expose a sitemap, advertise it from robots.txt, fix the broken homepage archive link, and guarantee fallback article JSON-LD when the upstream SEO/schema payload is incomplete.

## Spec Reference
- Spec Path: None required for this focused SEO/discoverability implementation
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
- Add a dedicated sitemap controller and `/sitemap.xml` route that covers static pages, category archives, and article URLs.
- Update `public/robots.txt` to advertise the sitemap while keeping the site crawlable.
- Replace the homepage `/articles` hard-coded link with the real archive route.
- Add a fallback article schema builder so each article still emits valid `Article` JSON-LD when upstream schema data is missing.
- Run targeted verification for routing, rendering, and XML/schema output.

## Verification Evidence
- `php -l app/Http/Controllers/SitemapController.php` completed successfully on June 29, 2026.
- `php -l app/Support/ArticleSchema.php` completed successfully on June 29, 2026.
- `php artisan route:list --name=sitemap` confirms the new `GET|HEAD sitemap.xml` route is registered.
- `php artisan tinker --execute='echo app()->call(app(\App\Http\Controllers\SitemapController::class))->getContent();'` returned valid sitemap XML with static and category URLs in the local environment.
- `php artisan tinker --execute='dump(\App\Support\ArticleSchema::hasPrimaryArticle([])); dump(\App\Support\ArticleSchema::fallback(...));'` confirmed the fallback helper detects a missing primary article schema and emits an `Article` JSON-LD graph.
