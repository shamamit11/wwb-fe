# Observability

- Define how logs, metrics, traces, and alerts are produced in this project.
- Document which events are operationally important before adding new background jobs or integrations.
- When introducing new workflows, ensure failures are observable without manual debugging.

## Logging
- Prefer structured logs with stable identifiers.
- Avoid logging secrets or raw tokens.

## Metrics & Tracing
- Document service-level latency, queue depth, retries, and external dependency health.
- Capture enough context to explain production failures without reproducing locally.
