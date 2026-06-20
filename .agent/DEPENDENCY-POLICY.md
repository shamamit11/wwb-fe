# Dependency Policy

- Use composer conventions consistently when changing dependencies.
- Prefer existing dependencies and project patterns before adding new packages.
- Justify new dependencies in the task log when they add runtime, security, or build complexity.

## Rules
- Avoid overlapping libraries that solve the same problem.
- Add transitive-heavy packages only when the benefit is clear.
- Update lockfiles only through the package manager, never by hand.
