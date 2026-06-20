# Spec Workflow

## Default Flow
1. Define the problem before implementation.
2. Draft or update a product or feature spec.
3. Add a technical design for non-trivial implementation changes.
4. Review the spec for scope, risks, and testable acceptance criteria.
5. Move approved work into `.agent/specs/active/`.
6. Implement against requirement IDs and acceptance criteria.
7. Verify behavior against the spec, not just against passing builds.
8. Move the completed spec to `.agent/specs/accepted/`.

## Agent Rule
- If there is no active spec for a meaningful feature change, create or request one before coding.
- If a task changes intended behavior, update the relevant spec as part of the same work.
