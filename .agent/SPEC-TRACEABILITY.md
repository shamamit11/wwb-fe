# Spec Traceability

Use traceability to connect product intent to implementation and verification.

## Traceability Rules
- Every active task should reference a spec path.
- Requirements should have stable IDs such as `REQ-1`, `REQ-2`.
- Acceptance criteria should have stable IDs such as `AC-1`, `AC-2`.
- Tests or validation notes should cite the acceptance criteria they prove.

## Mapping
- Spec requirement -> module or file
- Acceptance criterion -> test command or manual verification step
- Rollout requirement -> deployment, migration, or config change
