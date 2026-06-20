# Spec: Public posts hydrate from service API

## Summary
Replace frontend reliance on local `ArticleCatalog` content for article listing, article detail, related articles, and search results with the public posts/search endpoints exposed by `service`.

## Requirements
- PP-1: Article archive pages must source article cards from the public posts API and must not fall back to local post catalog content when the API is empty or unavailable.
- PP-2: Article detail pages must source the article payload, related articles, and SEO metadata from the public post detail API and return `404` when the service has no matching slug.
- PP-3: Search results must source matches from the public search API and keep linking each result to the existing article detail route.
- PP-4: Category archive titles, descriptions, and canonical URLs must remain SEO-safe and must not depend on local article catalog labels.

## Acceptance Criteria
- AC-1: `/articles` renders archive SEO metadata and service-backed article links.
- AC-2: `/articles/category/{slug}` renders category-specific headings/canonicals and only service-backed cards.
- AC-3: `/articles/{slug}` renders service-backed detail content, related articles, and article SEO metadata; unknown slugs return `404`.
- AC-4: `/search?q=...` renders service-backed search results and an empty state when nothing matches.
