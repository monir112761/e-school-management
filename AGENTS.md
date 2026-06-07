# AGENTS.md

## Purpose
This file gives AI coding agents a quick, practical summary of the `e-school-management` repository and its conventions.

## Project overview
- Laravel 12 project using PHP 8.2.
- Multi-tenant architecture powered by `stancl/tenancy`.
- Role and permission support via `spatie/laravel-permission`.
- Frontend assets built with Vite and Tailwind CSS.
- Primary entry points: `routes/web.php` for central app routes and `routes/tenant.php` for tenant-specific routes.

## Key build and development commands
- `composer install`
- `cp .env.example .env` (or use the existing `.env` file)
- `php artisan key:generate`
- `php artisan migrate`
- `npm install`
- `npm run build`
- `npm run dev`
- `php artisan test`

## Important files and directories
- `app/Providers/TenancyServiceProvider.php` - tenant route loading, tenancy event handling, and middleware priority.
- `config/tenancy.php` - tenancy bootstrappers, DB connection strategy, filesystem/cache tenancy, and tenant migration settings.
- `routes/tenant.php` - tenant route definitions and tenancy middleware group.
- `routes/web.php` - central application routes.
- `app/Http/Controllers/` - backend controllers.
- `resources/js/` and `resources/css/` - frontend assets managed by Vite.

## Agent guidance
- Preserve existing tenant separation: central routes in `routes/web.php`, tenant routes in `routes/tenant.php`.
- When modifying data access or routing, keep `stancl/tenancy` initialization and tenant context in mind.
- Prefer small, exact file edits rather than broad sweeping changes.
- Do not assume the project has complete documentation beyond the Laravel skeleton README.
- Use `php artisan` and `npm` scripts defined in `composer.json` and `package.json` for testing and build validation.

## Notes for Claude-style agents
- Be concise, factual, and prioritize repository-specific conventions over generic Laravel assumptions.
- If asked to update code, suggest code snippets or patch-style edits with minimal impact.
- Focus on tenant-aware behavior first, then general Laravel conventions.
