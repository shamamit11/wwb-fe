# Feature Spec: Contact Page

## Status
- Active

## Problem
The site has no dedicated Contact page. It needs a focused contact experience that fits the existing marketing system while intentionally avoiding address, map, phone, or direct email clutter.

## Goals
- Add a dedicated Contact route rendered through the shared marketing layout.
- Keep the page focused on a single contact form experience.
- Preserve the established brand, typography, spacing, and editorial tone.
- Reuse shared SEO infrastructure for page-specific metadata.

## Non-Goals
- Form submission persistence or backend delivery.
- Contact details such as address, map embed, phone number, or direct email display.
- CRM or newsletter integrations.

## Users / Actors
- Site visitors who want to start a conversation with the publication.

## Requirements
- REQ-1: The app must expose a dedicated Contact route rendered through Blade and Livewire.
- REQ-2: The page must use the shared marketing layout and existing CSS system.
- REQ-3: The page must present only a contact form flow and supporting editorial copy, with no address, location, map, email, or phone details shown.
- REQ-4: The form must provide interactive validation and a submitted state without a full-page reload.
- REQ-5: Main site links to contact should point to the dedicated Contact route.

## Acceptance Criteria
- AC-1: Given a request to the Contact route, when the page loads, then it renders through the shared marketing layout and shows a form-focused contact page.
- AC-2: Given invalid or missing form input, when the form is submitted, then validation feedback is shown without a full-page reload.
- AC-3: Given valid form input, when the form is submitted, then a success state is shown without displaying address, map, email, or phone details.
- AC-4: Given the page source is reviewed, when metadata and navigation links are inspected, then the page has contact-specific SEO metadata and the site contact links target the dedicated Contact route.

## API / Interface Changes
- Adds a new frontend Contact route and Livewire component.

## Data / State Changes
- Introduces component-local form state and a submitted confirmation state.

## Risks
- A contact form can feel too plain if it is not given enough editorial framing.
- Validation state can regress if form fields and rules drift apart.

## Open Questions
- None for the initial implementation.

## Rollout / Migration
- Add the page without changing existing page behavior beyond contact navigation targets.

## Test Plan
- Add focused feature tests for route render, validation behavior, success state, and navigation linkage.
- Run targeted feature tests and a production asset build.
