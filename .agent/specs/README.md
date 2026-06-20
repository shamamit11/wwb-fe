# Specs Workspace

This directory supports spec-driven development.

## Layout
- `INDEX.md`: entry point for navigating the spec catalog
- `proposed/`: ideas or changes that are not approved yet
- `active/`: approved specs currently being implemented
- `accepted/`: implemented specs that define current intended behavior
- `archived/`: retired or replaced specs
- `templates/`: reusable spec and design templates

## Rule
- New feature work should start from a spec in `proposed/` or `active/`.
- Agents should not treat implementation code as the only source of truth for intended behavior.
