# Feature Spec: Article Detail Page

## Status
- Active

## Problem
The site has a homepage and article listing page, but no dedicated editorial detail page that carries the same visual system and lets visitors read full articles in context.

## Goals
- Add a dedicated article detail route and page using the shared marketing layout.
- Reuse the same brand system, typography, spacing, and card language already established on the homepage and article listing page.
- Support article-specific SEO metadata, contextual article body sections, and related-article navigation.
- Move article content into a shared source usable by both the listing and detail pages.

## Non-Goals
- CMS persistence or authoring workflows.
- Rich text ingestion from an external API.
- Social share integrations beyond static UI affordances.

## Users / Actors
- Site visitors reading a specific article.

## Requirements
- REQ-1: The app must expose a dedicated article detail route by article slug.
- REQ-2: The page must use the shared marketing layout and shared article data source.
- REQ-3: The page must render a hero/header area, article body, embedded CTA block, tags, trending topics, and related articles aligned with the supplied visual direction.
- REQ-4: Article cards in the all-articles page must link into the detail route.
- REQ-5: The detail page must provide article-specific SEO metadata through the shared SEO component.

## Acceptance Criteria
- AC-1: Given a request to a known article slug, when the page loads, then it renders through the shared marketing layout and displays the article title and content.
- AC-2: Given a request to an unknown article slug, when the route resolves, then the app returns a 404 response.
- AC-3: Given a visitor browses the all-articles page, when they interact with an article card or title, then they can navigate to the corresponding detail page.
- AC-4: Given the article detail page source is reviewed, when metadata is inspected, then title, description, canonical URL, and Open Graph/Twitter metadata are specific to that article.

## API / Interface Changes
- Adds a new article detail frontend route and Livewire component.
- Introduces a shared article catalog support class used by multiple pages.

## Data / State Changes
- Article listing and article detail content move into a shared in-app catalog structure.

## Risks
- Shared content extraction can regress the listing page if field names drift.
- Detail page composition can feel visually disconnected if not anchored to the existing marketing system.

## Open Questions
- None for the initial implementation.

## Rollout / Migration
- Add the detail page alongside the existing listing page without changing other routes.

## Test Plan
- Add focused feature tests for article detail route render, 404 behavior, and list-to-detail linkage.
- Run the current article/home feature tests and a production asset build.
