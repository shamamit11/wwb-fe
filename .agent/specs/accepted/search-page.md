# Feature Spec: Search

## Status
- Accepted

## Problem
The navigation shows a search icon, but it is not interactive and the site has no search results page for discovering articles.

## Goals
- Make the navigation search affordance clickable and usable.
- Add a dedicated search results page for article discovery.
- Ensure search results link into the existing article detail pages.

## Non-Goals
- Building advanced ranking, typo tolerance, or faceted search.
- Integrating with an upstream search API unless it already exists and is stable.

## Users / Actors
- Site visitors searching for editorial content.

## Requirements
- REQ-1: The navigation search icon must open a usable search interaction.
- REQ-2: The application must expose a dedicated search results route.
- REQ-3: Searching must return matching articles and display them on the results page.
- REQ-4: Search results must link to the existing article detail route.

## Acceptance Criteria
- AC-1: Given a marketing page renders, when the search icon is used, then the user can submit a query to the frontend search route.
- AC-2: Given a search query with matching articles, when the results page renders, then matching article cards are shown.
- AC-3: Given a search result is shown, when its title or card is clicked, then it routes to the existing article detail page.
- AC-4: Given a search query with no matches, when the results page renders, then it shows an empty-state message instead of broken layout.

## API / Interface Changes
- Adds a frontend search route and Livewire search results page.

## Data / State Changes
- Search query is URL-addressable through the results route query string.

## Risks
- Local catalog search may diverge from future service-backed article content.

## Open Questions
- None.

## Rollout / Migration
- Replace the inert header search button in place.

## Test Plan
- Add focused feature tests for the search route, matching results, and empty state.
