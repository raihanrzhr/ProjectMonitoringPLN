<!-- Copilot instructions for ProjectMonitoringPLN -->
# Copilot / AI contributor instructions — ProjectMonitoringPLN

Purpose: Give AI coding agents the essential, discoverable knowledge to be productive in this Laravel app.

- Project type: Laravel application (skeleton derived from Laravel 12). Key manifests: `composer.json`, `package.json`.
- PHP requirement: ^8.2 (see `composer.json`). Frontend builds use Vite + Tailwind (see `vite.config.js`, `package.json`).

Quick architecture and entry points
- Routes: primary HTTP routes live in `routes/web.php` (minimal now) — add new web routes there. API routes appear in `routes/api.php` when present.
- Controllers: `app/Http/Controllers/*`. The repo currently contains the base `Controller.php`; add feature controllers here following PSR-4 `App\Http\Controllers`.
- Models: `app/Models` (example: `app/Models/User.php`). Models use Eloquent and PSR-4 namespacing `App\`.
- Views: Blade templates are under `resources/views` (example: `resources/views/welcome.blade.php`).
- Migrations/factories/seeders: `database/migrations`, `database/factories`, `database/seeders`.

Developer workflows (commands you should use)
- Install dependencies (PowerShell):
  - Composer: `composer install`
  - Node: `npm install`
- Quick dev environment (project provides a composer script named `dev` that runs server, queue listener and vite concurrently):
  - `composer run dev` (recommended for local dev; it runs `php artisan serve`, `php artisan queue:listen`, and `npm run dev`).
  - Alternatively run services manually: `php artisan serve` + `npm run dev`.
- Create / prepare env/database for first run (project post-create scripts assume these):
  - Ensure env exists: `php -r "file_exists('.env') || copy('.env.example', '.env')"` (PowerShell compatible)
  - `php artisan key:generate`
  - `php artisan migrate --graceful`
- Tests:
  - `composer test` (clears config and runs `php artisan test` — the repo uses Pest/PHPUnit)
  - `vendor/bin/pest` or `vendor/bin/phpunit` are also available if needed.
  - Note: `phpunit.xml` config forces `DB_CONNECTION=sqlite` and `DB_DATABASE=:memory:` for tests (in-memory DB), so tests should be isolated and fast.
- Lint/format: `vendor/bin/pint` is available (see `composer.json` dev deps).

Project-specific patterns & gotchas
- Composer scripts: see `composer.json` scripts. The `post-create-project-cmd` will try to `touch database/database.sqlite` and run `php artisan migrate` — be aware on Windows the repo may rely on the PHP copy/touch behaviors.
- Database in tests: tests rely on SQLite in-memory via `phpunit.xml`. If a new test requires a file sqlite DB, adjust the env accordingly or create `database/database.sqlite`.
- Queue: `composer dev` runs `php artisan queue:listen --tries=1`. Tests set `QUEUE_CONNECTION=sync` in `phpunit.xml` (synchronous queue for tests). If you change queue behavior, update tests accordingly.
- Frontend: Vite is used. Source files are under `resources/js` and `resources/css` (see `package.json` and `vite.config.js`). Use `npm run dev` for hot reload and `npm run build` for production bundles.
- Typing pattern: `app/Models/User.php` shows typed properties and methods (e.g., `protected function casts(): array`). Follow existing typed-return conventions where present.

Integration points and external dependencies
- Laravel framework core via Composer (`laravel/framework`).
- Frontend toolchain: Vite, Tailwind, laravel-vite-plugin (see `package.json`).
- Testing: Pest (`pestphp/pest`, `pestphp/pest-plugin-laravel`).
- Runtime: PHP 8.2 required; CI or contributors must use compatible PHP.

Where to change code for common tasks (examples)
- Add an HTTP endpoint: create a controller in `app/Http/Controllers`, add a route in `routes/web.php`, and a view under `resources/views`.
- Add a database-backed feature: create migration in `database/migrations`, model in `app/Models`, factory in `database/factories`, and seeder in `database/seeders`.
- Add JS/CSS assets: edit `resources/js` or `resources/css`, then run `npm run dev` / `npm run build`.

What not to assume
- This repository is mostly a Laravel skeleton. Many parts are default Laravel behavior — do not remove or rework framework conventions without confirming with maintainers.

Files that exemplify important patterns (inspect these before code changes):
- `composer.json` (scripts, PHP requirement)
- `package.json` and `vite.config.js` (frontend build)
- `phpunit.xml` (test env overrides — in-memory sqlite)
- `routes/web.php`, `app/Models/User.php`, `app/Http/Controllers/Controller.php`, `resources/views/welcome.blade.php`

If something is unclear, ask for:
- Which environment the contributor uses (local Windows PHP/Xdebug specifics).
- Any CI configuration or deployment steps (none discovered in repo). If CI exists elsewhere, request the workflow files.

Keep edits minimal and framework-aligned: prefer adding migrations/controllers/views rather than restructuring existing framework folders.

— End of instructions —
