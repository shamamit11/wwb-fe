# Security

- Validate all external input and normalize authorization decisions.
- Never commit secrets, tokens, private keys, or production credentials.
- Treat logging, analytics, and exception reporting as potential data exfiltration surfaces.

## Review Checklist
- Authentication and authorization are explicit.
- Secrets are sourced from environment or platform secret stores.
- Error payloads do not expose internals.
- External integrations have timeouts and failure handling.
