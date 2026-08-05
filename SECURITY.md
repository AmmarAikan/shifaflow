# Security policy

ShifaFlow is currently a demonstration project. Do not store real patient or medical data in the public demo.

## Reporting a vulnerability

Please report vulnerabilities privately through GitHub Security Advisories for this repository. Do not open a public issue containing credentials, personal data, exploit payloads, or medical information.

## Security baseline

- PHP 8.2 or newer and a supported MySQL 8 release.
- HTTPS is mandatory outside local development.
- Secrets are supplied through environment variables and never committed.
- Passwords use PHP's `password_hash` and are rehashed when the runtime policy changes.
- State-changing requests require a CSRF token.
- Database access uses native prepared statements.
- Authorization is enforced on the server for every protected workflow.
- Important user and appointment actions are written to an audit log.

## Before real clinical use

Commission an independent penetration test and privacy review, define retention and backup policies, add MFA for privileged users, implement verified password recovery, encrypt backups, monitor audit events, and validate all legal and health-data requirements for the operating country.
