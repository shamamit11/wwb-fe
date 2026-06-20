# Feature Spec: Resources Page

## Status
- Active

## Problem
The site needs a dedicated resources page for downloadable assets, templates, and guides that extends the existing brand system and gives users a structured way to browse practical tools.

## Goals
- Add a dedicated resources route rendered through the shared marketing layout.
- Preserve the visual system established by the homepage, article listing, and article detail pages.
- Support resource category filtering and sorting through Livewire.
- Reuse a shared in-app content source for maintainability.

## Non-Goals
- Real file downloads or gated access flows.
- Search integration or backend persistence.
- User accounts or resource personalization.

## Users / Actors
- Site visitors browsing downloadable or reference resources.

## Requirements
- REQ-1: The app must expose a dedicated resources route rendered through Blade and Livewire.
- REQ-2: The page must use the shared marketing layout, branding, and existing CSS system.
- REQ-3: The page must render a featured resource hero, filter chips, sort control, resource grid, and newsletter CTA aligned with the supplied visual direction.
- REQ-4: Category filtering and sorting must work without a full-page reload.
- REQ-5: The page must provide page-specific SEO metadata via the shared SEO component.

## Acceptance Criteria
- AC-1: Given a request to the resources route, when the page loads, then it renders through the shared marketing layout and displays the featured resource and resource grid.
- AC-2: Given a visitor selects a category filter, when the filter updates, then only matching resources appear and the visible count updates accordingly.
- AC-3: Given a visitor changes the sort order, when the selection updates, then the resource ordering changes without a full-page reload.
- AC-4: Given the resources page source is reviewed, when metadata is inspected, then title, description, canonical URL, and Open Graph/Twitter metadata are specific to the resources page.

## API / Interface Changes
- Adds a new frontend resources route and Livewire component.
- Introduces a shared resource catalog support class.

## Data / State Changes
- Resource content is defined in a shared in-app catalog structure for reuse by the page.

## Risks
- A separate resource design language could drift from the site-wide marketing system if it bypasses existing tokens and spacing patterns.
- Sorting and filtering interactions can become brittle if state is duplicated across view and component logic.

## Open Questions
- None for the initial implementation.

## Rollout / Migration
- Add the page without changing existing article or homepage behavior.

## Test Plan
- Add focused feature tests for route render, filter behavior, and sorting behavior.
- Run the targeted feature tests and a production asset build.
