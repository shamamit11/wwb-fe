# Project Memory

Only record stable, verified facts here.

## System Facts
- Project Name: fe
- Stack: Laravel
- Variant: Web
- Scaffold Version: 2.0.0

## Stable Facts
- [Add stable conventions here]
- Marketing/editorial pages can use the shared Blade layout at `resources/views/components/layouts/marketing.blade.php`.
- Shared site chrome and navigation metadata are centralized in `config/site.php`.
- Shared resource content for the resources page is centralized in `app/Support/ResourceCatalog.php`.
- The About page is a dedicated marketing route at `/about`, not a homepage anchor section.
- The About page can hydrate hero, mission, stats, values, team, and SEO content from the public `/api/v1/public/about` payload and safely omits empty sections when the payload is sparse.
- The Contact page is a dedicated marketing route at `/contact` and intentionally exposes only a form flow, without address, map, phone, or direct email details.
- The Contact page can hydrate hero, form, reasons, and SEO content from the public `/api/v1/public/contact` payload and submits form entries to `/api/v1/public/contact/submit`.
- Privacy Policy and Terms pages are dedicated simple legal routes at `/privacy-policy` and `/terms-and-conditions`, rendered through the shared marketing layout and hydrated from the public `public/pages/{slug}` endpoint.
- Footer categories are hydrated from the public categories endpoint through `BlogContentService` with cached fallback config, and category links target `/articles/category/{slug}`.
- Shared footer brand name, description, social links, and legal links are hydrated from the public `site-settings` singleton, while footer categories remain sourced from the public categories endpoint.
- The frontend publishes a cached RSS feed at `/rss.xml`, sourced from the service application's public RSS endpoint, and the footer RSS link targets that route.
- The frontend search experience uses a dedicated `/search` results page with a header-triggered search dialog and article-detail links.
- Article archive, article detail, related articles, and public search results are hydrated from the service application's `public/posts` and `public/search` endpoints instead of local article fallback content.
- The homepage route resolves service content through `BlogContentService`, with `WIDEWEB_BLOG_API_HOMEPAGE_PATH` defaulting to `public/home` and the page falling back to embedded defaults when upstream homepage data is unavailable.
- Shared head SEO metadata can include a Google site verification meta tag sourced from `GOOGLE_SITE_VERIFICATION` through `config/site.php`.
- Homepage and resources newsletter forms post to the public `public/newsletter/subscribe` endpoint through `BlogContentService`, using validated email input plus route-specific source metadata and auto-dismissing toast feedback.
- The frontend publishes a crawlable sitemap at `/sitemap.xml` through `SitemapController`, covering static pages plus category and article URLs from `BlogContentService`, and `public/robots.txt` advertises that sitemap.
- Article pages append a frontend-generated fallback JSON-LD graph from `App\Support\ArticleSchema` whenever upstream schema payloads do not include a primary `Article`/`BlogPosting` entity.
- The frontend serves `/robots.txt` through `RobotsController` so the sitemap reference is emitted as an absolute URL derived from Laravel routing instead of a static file.
- The frontend sitemap article entries are sourced from the service application's `public/sitemap` endpoint through `BlogContentService::sitemapEntries()`, not rebuilt from the generic `public/posts` listing.
