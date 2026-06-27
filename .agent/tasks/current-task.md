# Task: Polish current homepage article archive

## Scope
Refine the styling and visual polish of the current homepage/article archive only. Keep the existing structure, content, and backend behavior intact while improving spacing, hierarchy, card consistency, button polish, newsletter layout, and footer/header balance.

## Spec Reference
- Spec Path: None required for this styling-only refinement
- Requirement IDs: N/A
- Acceptance Criteria IDs: N/A

## Checklist
- [x] Confirm spec or draft one if required
- [x] Research the minimal file set
- [x] Record implementation plan
- [x] Implement focused changes
- [x] Run verification
- [ ] Update docs or manifest if stable conventions changed

## Plan
- Treat the active `/` route article archive as the homepage target because it matches the requested structure.
- Refine shared header and footer styling for stronger alignment, spacing, and interaction polish.
- Introduce reusable archive page/card/button/form classes in the shared stylesheet and apply them to the article archive Blade view.
- Run a frontend build and inspect the rendered page output for structural regressions.

## Verification Evidence
- `npm run build` completed successfully on June 27, 2026 and produced updated Vite assets.
- Vite emitted a Node version warning for local Node `22.1.0` versus the recommended `22.12+`, but the production bundle still completed without build errors.
