# Testing Guide

Detected tools: PHPUnit.

- Use Pest or PHPUnit for service, HTTP, and integration tests.
- Use model factories and database reset helpers.

## Validation Standard
- Run the narrowest relevant test command first.
- Run broader integration or build checks before finishing a task.
- Record the exact verification commands in `.agent/tasks/current-task.md`.
- Link verification back to acceptance criteria IDs where possible.
