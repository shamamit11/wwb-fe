# Feature Spec: All Articles Page

## Status
- Active

## Problem
The site needs an editorial listing page that extends the homepage design system and presents a broader catalog of articles. The page should preserve the brand, reusable layout, and shared styling while introducing a browsable article index with filters and pagination-style expansion.

## Goals
- Add a dedicated `All Articles` page using the shared marketing layout.
- Preserve the existing brand system, spacing, typography, color palette, and card language established by the homepage.
- Support category filtering and a load-more interaction through Livewire.
- Reuse the existing SEO layout pattern for this new page.

## Non-Goals
- Backend article persistence.
- Real search integration.
- CMS-driven filters or pagination from an external API.

## Users / Actors
- Site visitors browsing all editorial content.

## Requirements
- REQ-1: The app must expose a dedicated all-articles route rendered through Blade and Livewire.
- REQ-2: The page must use the shared marketing layout, header, footer, and existing visual system.
- REQ-3: The page must render a featured editorial region and a filterable article grid aligned with the provided visual direction.
- REQ-4: Category filters and load-more behavior must work without a full-page reload.
- REQ-5: The page must provide reusable SEO metadata via the shared layout.

## Acceptance Criteria
- AC-1: Given a request to the all-articles route, when the page loads, then it renders through the shared marketing Blade layout and a Livewire component.
- AC-2: Given a visitor clicks a category chip, when the filter updates, then the article grid shows only matching articles and resets the visible count appropriately.
- AC-3: Given more filtered articles exist than the initial visible count, when the visitor clicks the load-more control, then additional cards appear without a full-page reload.
- AC-4: Given the all-articles page source is reviewed, when shared head metadata is inspected, then the page sets its own title, description, canonical URL, and Open Graph/Twitter metadata through the existing SEO component.

## API / Interface Changes
- Adds a new frontend route and Livewire component for the article index page.

## Data / State Changes
- Article listing data is defined in the Livewire component for structured rendering and filter state.

## Risks
- The page could drift visually from the homepage if new card styles bypass the shared design language.
- Responsive layout around the lead article area can regress if the split-card composition is not tested at multiple breakpoints.

## Open Questions
- None for the initial implementation.

## Rollout / Migration
- Add the new page without changing the existing homepage behavior.

## Test Plan
- Add a focused feature test covering route render and filterable page content.
- Run a production asset build after the view additions.
