# Legal Pages API Spec

## Context
- Frontend legal routes `/privacy-policy` and `/terms-and-conditions` should hydrate from the public pages endpoint instead of using hardcoded page copy.

## Requirements
- LP-1: The frontend must request legal page content from `GET /api/v1/public/pages/{slug}` using slugs `privacy-policy` and `terms-and-conditions`.
- LP-2: Legal pages must preserve dedicated route URLs and the shared marketing layout.
- LP-3: The page title, summary/description, effective date, canonical URL, and body content should prefer API-managed content with safe fallbacks when fields are missing.
- LP-4: Markdown body content from `content_markdown` must render as readable page content.

## Acceptance Criteria
- AC-1: Visiting `/privacy-policy` renders the Privacy Policy page title and API-provided body content.
- AC-2: Visiting `/terms-and-conditions` renders the Terms and Conditions page title and API-provided body content.
- AC-3: The legal routes continue to emit route-specific SEO metadata and canonical links.
- AC-4: `BlogContentService` caches public legal page lookups by slug.
