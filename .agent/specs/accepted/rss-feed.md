# Feature Spec: RSS Feed

## Status
- Accepted

## Problem
The site footer exposes an RSS Feed link, but it does not point to a live feed generated from the service application's public RSS endpoint.

## Goals
- Publish a valid RSS feed from the frontend application.
- Source feed items from the service application's public RSS endpoint.
- Expose the feed from a stable frontend URL and wire the footer link to it.

## Non-Goals
- Building an Atom feed.
- Reworking archive functionality.

## Users / Actors
- RSS readers and syndication consumers.
- Site visitors who use the footer RSS link.

## Requirements
- REQ-1: The frontend application must expose a stable RSS feed URL.
- REQ-2: Feed items must be hydrated from `public/rss` on the service API.
- REQ-3: The footer RSS link must point to the frontend RSS route.
- REQ-4: The RSS response must be valid XML with channel metadata and item entries.

## Acceptance Criteria
- AC-1: Given a request to the frontend RSS route, when the response is returned, then it uses an RSS XML content type and includes channel metadata for Wide Web Blog.
- AC-2: Given the service RSS payload contains items, when the frontend feed is rendered, then the XML includes those items as RSS `<item>` entries.
- AC-3: Given the footer is rendered, when the RSS link is inspected, then it points to the frontend RSS route instead of `#`.

## API / Interface Changes
- Adds cached RSS retrieval to `BlogContentService`.
- Adds a frontend RSS route and response renderer.

## Data / State Changes
- None beyond cached service RSS payloads.

## Risks
- Invalid XML escaping could break feed parsing.
- Upstream service outages could make the feed unavailable if not handled defensively.

## Open Questions
- None.

## Rollout / Migration
- Replace the footer placeholder link in place.

## Test Plan
- Add focused feature tests for the RSS route and footer link.
