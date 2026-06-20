# Deployment

- Document environments, release steps, rollback paths, and migration order here.
- Agents should not change deployment-critical behavior without confirming environment assumptions.

## Minimum Expectations
- Build and runtime commands are documented.
- Data migrations are ordered safely.
- Feature flags or config toggles are recorded when needed.
