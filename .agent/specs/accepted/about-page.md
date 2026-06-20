# Feature Spec: About Page

## Status
- Active

## Problem
The site has core editorial and resource pages, but it does not yet have a dedicated About page that explains the publication’s mission, values, and team in the same visual system.

## Goals
- Add a dedicated About route rendered through the shared marketing layout.
- Preserve the established brand system while introducing a strong editorial identity page.
- Present mission, values, credibility signals, and team members in a structured, reusable format.
- Reuse shared SEO infrastructure for page-specific metadata.

## Non-Goals
- Team profile detail pages.
- Real hiring or contact form workflows.
- CMS-backed organization data.

## Users / Actors
- Site visitors learning what Wide Web Blog is and who runs it.

## Requirements
- REQ-1: The app must expose a dedicated About route rendered through Blade and Livewire.
- REQ-2: The page must use the shared marketing layout, branding, and CSS system.
- REQ-3: The page must render a hero/story area, mission section, values section, and team section aligned with the supplied visual direction.
- REQ-4: The page must provide page-specific SEO metadata via the shared SEO component.
- REQ-5: Main site navigation should point the About item to the dedicated route.

## Acceptance Criteria
- AC-1: Given a request to the About route, when the page loads, then it renders through the shared marketing layout and displays the mission, values, and team sections.
- AC-2: Given the About page source is reviewed, when metadata is inspected, then title, description, canonical URL, and Open Graph/Twitter metadata are specific to the About page.
- AC-3: Given the primary site navigation is rendered, when the About link is inspected, then it points to the dedicated About route instead of a homepage anchor.

## API / Interface Changes
- Adds a new frontend About route and Livewire component.

## Data / State Changes
- About page content is represented in structured component data for maintainability.

## Risks
- A generic corporate layout could feel inconsistent with the editorial tone if not anchored to the existing brand language.
- Team/mission content can become too static if the structure is not flexible enough for future updates.

## Open Questions
- None for the initial implementation.

## Rollout / Migration
- Add the page without changing existing page behavior beyond the About navigation target.

## Test Plan
- Add focused feature tests for route render, metadata, and navigation linkage.
- Run targeted feature tests and a production asset build.
