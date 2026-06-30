# Deploy Guide — Vercel + PlanetScale (short)

This file explains the minimal steps to deploy this PHP + MySQL portfolio app to Vercel using an external managed MySQL database (PlanetScale recommended). It assumes you already have the project in a Git repository (GitHub) and have `vercel.json` + `composer.json` (already added).

---

## Summary (recommended)
- Use Vercel for PHP hosting (server runtime via `@vercel/php`).
- Use PlanetScale (or another managed MySQL DB) as the database — Vercel does not host MySQL.
- Export your local DB and import into the remote DB (or recreate schema via `config/database.php`).
- Set environment variables on Vercel for DB credentials.
- Deploy the repo to Vercel (connect GitHub).

---

## Prerequisites
- GitHub repo with your project.
- Vercel account.
- PlanetScale account (or other managed MySQL: ClearDB, Neon, Amazon RDS, etc.).
- `mysqldump` and `mysql` client locally for export/import (or use PlanetScale CLI `pscale`).

---

## 1) PlanetScale: create database
1. Create a new database in PlanetScale dashboard.
2. Create a password (Service Password) or use the recommended connection method. Note that PlanetScale often requires using `pscale connect` as a secure tunnel for local imports — check PlanetScale docs for importing data (they provide `pscale` CLI instructions).

Important: If you cannot connect directly from Vercel to PlanetScale using simple host/user/password, you can:
- Use PlanetScale's recommended connection string and create a database user/password in the dashboard.
- Or use another managed MySQL provider that exposes a standard host/port/username/password.

---

## 2) Export local DB
Run locally in your project machine (replace MySQL credentials as needed):

```bash
mysqldump -u root -p portfolio_db > portfolio_dump.sql
```

If `mysqldump` is not available, you can export via phpMyAdmin or MySQL Workbench.

---

## 3) Import data into remote DB
If your provider supports direct import with `mysql` client:

```bash
mysql -h <DB_HOST> -u <DB_USER> -p<DB_PASS> <DB_NAME> < portfolio_dump.sql
```

If using PlanetScale, follow PlanetScale import docs — often you run `pscale connect <db> main --port 3306` then run the `mysql` import through that tunnel. Example:

```bash
pscale connect <your-db> main --port 3306
# in another terminal
mysql -h 127.0.0.1 -P 3306 -u <user> -p <DB_NAME> < portfolio_dump.sql
```

---

## 4) Set environment variables in Vercel
In Vercel project → Settings → Environment Variables add:
- `DB_HOST` — host provided by DB provider (for PlanetScale it might be a host like `aws.connect.psdb.cloud` or `127.0.0.1` when using `pscale connect` locally)
- `DB_USER`
- `DB_PASS`
- `DB_NAME`

Note: `config/database.php` in this repo already reads `DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME` from environment, so no further code edit is required.

---

## 5) Upload repository to GitHub and deploy on Vercel
1. Push your project to GitHub.
2. In Vercel, `New Project` → Import from GitHub → choose repo → Deploy.
3. Vercel will use `vercel.json` and the `@vercel/php` builder. After deployment, your site will be available at `https://<project>.vercel.app`.

---

## 6) Verify and test
- Open `https://<project>.vercel.app/resume.php` to check public resume rendering.
- Open `https://<project>.vercel.app/admin/login.php` to login (default admin `admin` / `admin123` — change password!).

---

## 7) Important runtime notes
- Vercel filesystem is ephemeral — any file uploads to local `uploads/` folder will not persist across deployments/restarts. Use external storage for media:
  - Cloudinary (easy image hosting), or
  - AWS S3 / DigitalOcean Spaces.
- PlanetScale has some restrictions on DDL (ALTER TABLE) on some branches. Creating tables and initial imports are supported; for schema changes, review PlanetScale workflow.
- If your chosen DB requires TLS/SSL or special connection parameters, you may need to adjust `config/database.php` or use PDO with SSL options.

---

## Checklist (quick)
- [ ] Create GitHub repo and push project.
- [ ] Create PlanetScale (or other) database and note credentials.
- [ ] Export local DB (`portfolio_dump.sql`).
- [ ] Import `portfolio_dump.sql` into remote DB (follow provider docs).
- [ ] Set `DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME` in Vercel environment variables (and mark them for Production branch).
- [ ] Connect GitHub repo in Vercel and deploy.
- [ ] Test public site (`/resume.php`) and admin pages.
- [ ] Configure external image storage if you plan to upload images.

---

## Troubleshooting tips
- If the app shows DB connection errors: verify env vars, DB host reachability, and user/password correctness.
- For PlanetScale connection issues: use `pscale connect` for secure tunnelling, or follow PlanetScale’s DB password creation docs.
- To debug on Vercel: use Vercel build logs and the `vercel` CLI for local testing.

---

If you want, I can now:
- generate the `portfolio_dump.sql` locally (if mysqldump is available here) and prepare a zip of the project; OR
- create a short `README.md` file in the repo root linking to this guide and summarizing the two-step flow (deploy + import).

Tell me which next step you prefer.