# ShifaFlow — منصة شفاء لإدارة العيادات

ShifaFlow is an Arabic-first clinic workflow demo for managing users, appointments, contact messages, and basic clinical follow-up. It is a ground-up renewal of the former “Dar Al‑Shifa” prototype with a safer architecture and a deployment-ready container.

> The published demo must contain fictional data only. This repository is not yet certified for real medical records.

## Hosting status

ShifaFlow was previously deployed on Railway at `shifaflow-production.up.railway.app`. That deployment is currently offline because its Railway trial expired; the application remains available locally through WampServer and is packaged for a future Railway or Docker deployment.

Use one of the fictional accounts below for local testing. Do not enter real patient or medical data.

## What is included

- Responsive Arabic RTL landing page and dashboard.
- Patient registration and secure email/phone login.
- Admin, doctor, and patient roles with server-side authorization.
- Appointment request, confirmation, cancellation, rejection, and completion flows.
- Doctor-only diagnosis and treatment notes for assigned appointments.
- Admin user controls and contact-message inbox.
- CSRF protection, prepared database statements, secure sessions, security headers, and audit logging.
- MySQL schema, idempotent setup script, automated tests, Docker, and GitHub Actions.

## Demo accounts

| Role | Email | Password |
|---|---|---|
| Admin | `admin@shifaflow.test` | `Demo@12345` |
| Doctor | `doctor@shifaflow.test` | `Demo@12345` |
| Patient | `patient@shifaflow.test` | `Demo@12345` |

Change or disable all demo credentials before any non-demo deployment.

## Run with WampServer

1. Copy `.env.example` to `.env` and set the local MySQL values.
2. Run `C:\wamp64\bin\php\php8.3.14\php.exe bin\setup.php --seed`.
3. Open `http://localhost/my_clinic_2/my_clinic_2/`.

The new database defaults to `shifaflow_demo`; the former project database is not modified.

## Run with Docker

```bash
docker compose up --build
```

Open `http://localhost:8080`. The included MySQL volume preserves local demo data between container restarts.

## Quality checks

```bash
php bin/lint.php
php tests/run.php
```

GitHub Actions runs syntax checks, integration tests with MySQL, and a deployment-image build on every pull request.

## Deploying to Railway

The repository includes a root `Dockerfile` and `railway.toml` health check.

1. Create a Railway project and add a MySQL service.
2. Add a web service connected to this GitHub repository and deployment branch.
3. Reference the MySQL variables in the web service (`MYSQLHOST`, `MYSQLPORT`, `MYSQLDATABASE`, `MYSQLUSER`, `MYSQLPASSWORD`).
4. Add `APP_ENV=production`, `APP_DEBUG=false`, `APP_TIMEZONE=Asia/Riyadh`, and `SEED_DEMO=true` for the public portfolio demo.
5. Generate a public domain and verify `/health`, login, role access, and appointment creation.

For real use, set `SEED_DEMO=false`, provide strong `ADMIN_*` values privately, use a custom HTTPS domain, configure backups and monitoring, and complete the controls listed in [SECURITY.md](SECURITY.md).

## Project structure

```text
app/        Core security, database, authentication, and view helpers
bin/        Setup and quality-check scripts
database/   Versioned MySQL schema
public/     Web entry point and production assets
tests/      Dependency-free integration tests
views/      Arabic pages and dashboards
```

## Commercial readiness

ShifaFlow can become a real clinic product, but code quality alone is not enough. Before storing actual patient data, complete a local legal/privacy assessment, a professional security test, encrypted backup and recovery drills, MFA, password recovery, consent and retention workflows, incident response, observability, and operational access controls.
