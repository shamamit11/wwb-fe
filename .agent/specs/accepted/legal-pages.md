# Feature Spec: Privacy Policy and Terms Pages

## Status
- Active

## Problem
The site currently links Privacy Policy and Terms of Service to placeholders. It needs dedicated legal pages that fit the shared site layout without unnecessary visual complexity.

## Goals
- Add dedicated Privacy Policy and Terms routes.
- Keep the pages visually aligned with the shared marketing system but intentionally simple.
- Reuse a shared legal page view pattern to avoid duplication.
- Provide page-specific SEO metadata and real footer links.

## Non-Goals
- Dynamic legal content management.
- Rich interactions or Livewire state.
- Jurisdiction-specific legal review logic.

## Users / Actors
- Site visitors reviewing legal and usage information.

## Requirements
- REQ-1: The app must expose dedicated routes for Privacy Policy and Terms and Conditions.
- REQ-2: Both pages must render through the shared marketing layout.
- REQ-3: The pages must remain simple and content-focused, without decorative or interactive complexity.
- REQ-4: Footer links for Privacy Policy and Terms of Service must point to the dedicated routes.
- REQ-5: Each page must provide page-specific SEO metadata.

## Acceptance Criteria
- AC-1: Given a request to the privacy or terms route, when the page loads, then it renders through the shared marketing layout and shows the expected legal heading/content.
- AC-2: Given the page source is reviewed, when metadata is inspected, then title, description, and canonical URL are specific to that legal page.
- AC-3: Given the site footer is rendered, when the legal links are inspected, then they point to the dedicated privacy and terms routes.

## API / Interface Changes
- Adds two frontend legal routes and their Blade entrypoints.
- Adds a shared legal page component for content rendering.

## Data / State Changes
- None beyond static page content.

## Risks
- Over-design would conflict with the intended legal-page simplicity.
- Duplicated view structure would make future legal edits less maintainable.

## Open Questions
- None for the initial implementation.

## Rollout / Migration
- Replace placeholder footer links with real legal page routes.

## Test Plan
- Add focused feature tests for route render, metadata, and footer link targets.
- Run targeted feature tests.
