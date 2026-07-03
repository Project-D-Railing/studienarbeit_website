# Deploying this upgrade to an existing webspace

This covers taking an **already-running** Laravel 5.5 deployment (the old
setup, where `vendor/` was committed directly to git and deployed via
FTP/"auto deploy") and updating it in place to this PR's Laravel 13 / PHP
8.3+ codebase. For setting up a **brand new** environment from scratch, see
the setup guide provided separately (PHP version, fresh `.env`, database
creation).

## Before touching anything: back up

- **Database**: `mysqldump -u <user> -p <database> > backup-$(date +%F).sql`
  for the main DB. Also note down the `mysql2` (train/station tracking)
  connection details somewhere safe — you won't be modifying that database,
  just reconnecting the app to it.
- **Files**: zip/copy the current webspace directory (or at least `.env`
  and `storage/`) somewhere safe. If this is a plain FTP/cPanel deploy with
  no git history live on the server, this is your only rollback path.

## Step 1 — Switch the PHP version

Laravel 13 requires **PHP 8.3+**. Do this *before* deploying the new code,
but deploy the new code right after — old Laravel 5.5 code is not
guaranteed to run correctly on PHP 8.3, so don't leave old-code +
new-PHP running for long.

- **cPanel**: "MultiPHP Manager" → select the domain → choose **PHP 8.3**
  (or 8.4) → Apply.
- **Plesk**: Domain → PHP Settings → select 8.3/8.4.
- **Own server**: install `php8.3` (or 8.4) alongside the old version, then
  point the vhost/php-fpm pool at it and restart the web server.
- Check required extensions are enabled: `pdo_mysql`, `mbstring`, `xml`,
  `curl`, `bcmath`, `gd` (or `fileinfo`), `openssl`, `tokenizer`.
- Verify with `php -v` (SSH), or a temporary `<?php phpinfo();` file if
  there's no SSH access.

## Step 2 — Get the new code onto the server

**If the server has git + SSH:**
```bash
cd /path/to/webspace
git fetch origin
git checkout master   # once this PR is merged
git pull
```

**If it's an FTP-only / no-SSH host** (matches how `vendor/` was committed
before): since `vendor/` is no longer in git, a plain FTP upload of the
repo won't produce a working app anymore. Either:
- Build the release locally/in CI
  (`composer install --no-dev --optimize-autoloader && npm ci && npm run production`),
  then upload the whole tree including the freshly-built `vendor/` via FTP, or
- Check whether the host actually has SSH+Composer available even though
  it wasn't used before — that's the better long-term setup.

## Step 3 — Install dependencies (if you have SSH/Composer)

```bash
cd /path/to/webspace
composer install --no-dev --optimize-autoloader
npm ci && npm run production   # optional — public/css and public/js are already committed and work as-is
```

## Step 4 — Update `.env`

Don't overwrite the live `.env` with `.env.example` — you'll lose real
credentials. Instead, edit the **existing** `.env` in place and rename
these three keys (values stay the same, only the variable name changed):

| Old key         | New key            |
|------------------|---------------------|
| `CACHE_DRIVER`   | `CACHE_STORE`        |
| `QUEUE_DRIVER`   | `QUEUE_CONNECTION`   |
| `MAIL_DRIVER`    | `MAIL_MAILER`        |

Delete the `BROADCAST_DRIVER` and `PUSHER_*` lines if present (unused now).
Everything else — `DB_*`, `DB_*_SECOND` (the `mysql2` connection),
`APP_KEY`, `SESSION_*`, `REDIS_*` — keeps its existing name and value,
don't touch it.

**Do not run `php artisan key:generate` on an existing deployment** — that
invalidates all current sessions and any encrypted data. Keep the existing
`APP_KEY`.

## Step 5 — Database migration (careful step)

Laravel 11 renamed the `password_resets` table to `password_reset_tokens`.
Check status first:

```bash
php artisan migrate:status
```

If production still has the old `password_resets` table and hasn't run the
new consolidated migration, rename it manually first so no data/structure
is lost:

```sql
RENAME TABLE password_resets TO password_reset_tokens;
```

Then run:

```bash
php artisan migrate --force
```

The `mysql2` connection (train/station data) needs no migration — the app
only reads from it.

## Step 6 — Rebuild caches

```bash
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link   # only if not already linked
```

If switching PHP versions on the same server/path, also make sure stale
opcache/bytecode is cleared — restart PHP-FPM, or on shared hosting
without shell access this typically happens automatically when the PHP
version is switched in the control panel.

## Step 7 — Verify on the live site

- Load `/`, `/login`, `/register`, `/impressum` — should all return normal
  pages.
- Log in with an existing account (session/password hashes are unaffected
  — nothing about hashing changed).
- Load a `/station/{id}` or `/train/{class}/{number}` page to confirm the
  `mysql2` connection still works from the live environment.
- Check `storage/logs/laravel.log` for anything unexpected in the first
  few minutes.

## If something breaks

Roll back by restoring the file backup from the top of this guide and
switching PHP back to the old version in the hosting panel. Do the PHP
switch and the code deploy together (not one without the other) — the two
are coupled, since old code isn't guaranteed compatible with the new PHP
version either.
