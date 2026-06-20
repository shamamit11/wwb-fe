# Error Handling

- Map validation failures to HTTP 422.
- Log integration failures with contextual identifiers, not raw secrets.

## Universal Rules
- Keep user-facing failures readable and stable.
- Keep operational details in logs or observability tooling, not public payloads.
