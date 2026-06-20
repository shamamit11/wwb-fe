# Performance

- Keep request, render, and job hot paths explicit.
- Document caching, batching, pagination, and concurrency expectations before rewriting critical code.
- Add or update performance notes when introducing work with non-trivial latency or memory impact.

## Review Focus
- Avoid N+1 reads and duplicate network calls.
- Prefer focused profiling over speculative optimization.
- Validate large data flows, list rendering, and background job throughput.
