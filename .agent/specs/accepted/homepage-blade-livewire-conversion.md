# Feature Spec: Homepage Blade + Livewire Conversion

## Status
- Active

## Problem
The homepage exists as a standalone HTML prototype in `ref/home.html` with inline Tailwind configuration, inline styles, and no reusable Laravel view structure. The frontend needs a maintainable Blade + Livewire implementation that can support additional pages and consistent SEO metadata.

## Goals
- Convert the homepage prototype into Laravel Blade + Livewire.
- Extract reusable page chrome components such as layout, header, navigation, and footer.
- Move styling to the project Tailwind pipeline as the single CSS source.
- Establish a reusable SEO metadata pattern for future pages.

## Non-Goals
- Building backend CMS editing flows.
- Wiring newsletter forms or navigation links to real destinations beyond safe placeholders.
- Implementing unrelated visual redesigns outside the supplied homepage reference.

## Users / Actors
- Site visitors viewing the homepage.
- Developers adding future marketing/editorial pages.

## Requirements
- REQ-1: The `/` route must render the homepage through Blade and Livewire using project-local assets rather than the reference file directly.
- REQ-2: Shared page chrome must be extracted into reusable Blade components for layout, header/navigation, and footer.
- REQ-3: Homepage styling tokens and utilities must live in `resources/css/app.css` and use the existing Tailwind/Vite pipeline as the single CSS source.
- REQ-4: The page layout must accept reusable SEO inputs including title, description, canonical URL, and share image metadata.
- REQ-5: The homepage content structure must be represented in maintainable PHP/Blade data rather than one large static HTML file.

## Acceptance Criteria
- AC-1: Given a request to `/`, when the homepage renders, then it is served through the existing Laravel view entry and a Livewire component.
- AC-2: Given a future page needs metadata, when it uses the shared layout, then it can set title, description, canonical, and Open Graph/Twitter tags without duplicating head markup.
- AC-3: Given the homepage loads, when compiled assets are inspected, then the styling comes from `resources/css/app.css` via Vite rather than CDN Tailwind or inline Tailwind config.
- AC-4: Given the homepage structure is reviewed, when common chrome sections are examined, then header/navigation and footer are reusable Blade components instead of duplicated page markup.

## API / Interface Changes
- None externally.
- Internal view/component interfaces are added for layout metadata and shared navigation/footer data.

## Data / State Changes
- Homepage presentation data is defined in the Livewire component for structured rendering.

## Risks
- Large visual HTML conversions can introduce markup regressions if not kept componentized.
- Tailwind token migration from inline config to Tailwind 4 theme variables may require minor class adjustments.

## Open Questions
- None for the initial conversion.

## Rollout / Migration
- Replace the current placeholder homepage with the converted marketing page implementation.

## Test Plan
- Run targeted PHP tests for homepage rendering.
- Run a production asset build to verify Tailwind compilation succeeds with the new theme definitions.
