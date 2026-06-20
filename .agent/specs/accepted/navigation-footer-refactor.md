# Feature Spec: Navigation and Footer Refactor

## Status
- Accepted

## Problem
The primary navigation and footer still reflect earlier placeholder structure, and footer categories are hardcoded instead of using the category API exposed by the service application.

## Goals
- Simplify the primary navigation to the canonical site pages.
- Clean up footer company links and remove the outdated Editorial Guidelines item.
- Populate footer categories from the public categories endpoint with caching and safe fallback behavior.
- Make category footer links land on meaningful category archive states.

## Non-Goals
- Building dedicated category archive pages.
- Reworking page layouts outside the shared chrome updates.

## Users / Actors
- Site visitors navigating core pages and categories.

## Requirements
- REQ-1: Primary navigation must be reduced to Home, All Articles, Resources, About Us, and Contact Us.
- REQ-2: Footer company links must remove Editorial Guidelines and keep legal/contact links current.
- REQ-3: Footer categories must be sourced from the public categories endpoint with caching and fallback behavior.
- REQ-4: Category links must direct users to dedicated category archive pages.

## Acceptance Criteria
- AC-1: Given any marketing page renders, when the primary navigation is inspected, then it contains only the canonical page links requested by the user.
- AC-2: Given the footer renders, when the company links are inspected, then Editorial Guidelines is absent and the legal/contact links point to live routes.
- AC-3: Given the footer category list is rendered, when category data is available, then it reflects the service categories and links into dedicated category archive routes.
- AC-4: Given a category archive route is requested, when the page loads, then the matching filter is active instead of resetting to the default state.

## API / Interface Changes
- Adds cached category retrieval to the blog content service.
- Adds a footer view composer to provide dynamic category data.

## Data / State Changes
- Article listing category state becomes URL-addressable through canonical category path segments.

## Risks
- Service failures could break footer rendering if fallback behavior is not handled defensively.
- Category slug mismatches between local article data and remote taxonomy would break filtered linking.

## Open Questions
- None for the initial implementation.

## Rollout / Migration
- Replace the old shared chrome configuration in place.

## Test Plan
- Add focused feature tests for navigation, footer links, and category-filter routing behavior.
