# Architecture

## Stack
- Laravel
- Web

## Core Architecture
- Routes delegate into controllers and form requests.
- Controllers delegate into services or actions for business logic.
- Eloquent models and repositories coordinate persistence.

## Agent Rule
- Changes should preserve clear boundaries between transport, business logic, persistence, and async work.
