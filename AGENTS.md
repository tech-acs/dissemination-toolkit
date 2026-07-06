<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this project. These guidelines should be followed closely to ensure the best experience when building Laravel applications.

## Foundational Context

This project is a Laravel **package** (`Uneca\DisseminationToolkit`), not a standalone application. See the "Package Context" section below the boost block for the dev-vs-host path mapping and install-time behavior. Its main Laravel ecosystem packages & versions are below. You are an expert with them all. Ensure you abide by these specific packages & versions.

- php - 8.5

## Skills Activation

This project has domain-specific skills available in `**/skills/**`. You MUST activate the relevant skill whenever you work in that domain—don't wait until you're stuck.

## Conventions

- You must follow all existing code conventions used in this project. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the project's dependencies without approval.

## Frontend Bundling

- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `npm run build` or `npm run dev`. For the workbench dev skeleton, use `composer build` (builds assets) or `composer serve` (builds then serves). Ask them.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

## Replies

- Be concise in your explanations - focus on what's important rather than explaining obvious details.

=== boost rules ===

# Laravel Boost

## Tools

- Laravel Boost is an MCP server with tools designed specifically for this application. Prefer Boost tools over manual alternatives like shell commands or file reads.
- Use `database-query` to run read-only queries against the database instead of writing raw SQL in tinker.
- Use `database-schema` to inspect table structure before writing migrations or models.
- Use `get-absolute-url` to resolve the correct scheme, domain, and port for project URLs. Always use this before sharing a URL with the user.
- Use `browser-logs` to read browser logs, errors, and exceptions. Only recent logs are useful, ignore old entries.

## Searching Documentation (IMPORTANT)

- Always use `search-docs` before making code changes. Do not skip this step. It returns version-specific docs based on installed packages automatically.
- Pass a `packages` array to scope results when you know which packages are relevant.
- Use multiple broad, topic-based queries: `['rate limiting', 'routing rate limiting', 'routing']`. Expect the most relevant results first.
- Do not add package names to queries because package info is already shared. Use `test resource table`, not `filament 4 test resource table`.

### Search Syntax

1. Use words for auto-stemmed AND logic: `rate limit` matches both "rate" AND "limit".
2. Use `"quoted phrases"` for exact position matching: `"infinite scroll"` requires adjacent words in order.
3. Combine words and phrases for mixed queries: `middleware "rate limit"`.
4. Use multiple queries for OR logic: `queries=["authentication", "middleware"]`.

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.
- Use PHP 8 constructor property promotion: `public function __construct(public GitHub $github) { }`. Do not leave empty zero-parameter `__construct()` methods unless the constructor is private.
- Use explicit return type declarations and type hints for all method parameters: `function isAccessible(User $user, ?string $path = null): bool`
- Use TitleCase for Enum keys: `FavoritePerson`, `BestLake`, `Monthly`.
- Prefer PHPDoc blocks over inline comments. Only add inline comments for exceptionally complex logic.
- Use array shape type definitions in PHPDoc blocks.

</laravel-boost-guidelines>

## Package Context

This project is a Laravel **package** (`Uneca\DisseminationToolkit`), not a standalone Laravel application. Source, views, routes, config, and migrations live in package-relative paths and are wired into a host app via `DisseminationToolkitServiceProvider`. When editing, keep the development-time vs. host-app location in mind.

### Path mapping (dev location → where it lands in a host app)

| Concern | Dev location (this repo) | How it reaches the host app |
|---|---|---|
| PHP source (models, controllers, Livewire, etc.) | `src/` (namespace `Uneca\DisseminationToolkit\...`) | Autoloaded from the package — **not copied**. |
| Routes | `src/routes/web.php` | Loaded by `hasRoute('web')`. Not the host's `routes/`. |
| Views | `resources/views/**` | Namespaced as `dissemination::...` (e.g. `view('dissemination::manage.topic.index')`). |
| Config | `config/dissemination.php` | Published to host's `config/` via `--tag=dissemination-config`. Host's published copy wins over the package's. |
| Migrations | `database/migrations/*.php.stub` | Published to host's `database/migrations/` via `--tag=dissemination-migrations`. **Stubs get copied** — edits don't propagate to existing hosts until re-published. Also registered in `hasMigrations([...])`. |
| Factories | `src/Database/Factories/` | Loaded from the package; not the host's `database/factories/`. |
| Translations, assets, components | `resources/`, `src/Components/` | Published/namespaced as above. |

### The `deploy/` directory

`deploy/` holds files and assets that are copied into a host Laravel application by the install command `src/Commands/Dissemination.php` (`php artisan dissemination:install`). It is **not** package runtime code — it's a staging area for host-app installation. Contents:

- `deploy/jetstream-modifications/` — customized Jetstream actions and views, copied to the host's `app/Actions/Fortify` and `resources/views/`.
- `deploy/resources/` — CSS, JS, and the ChartEditor, copied to the host's `resources/css`, `resources/js`.
- `deploy/npm/` — `tailwind.config.js` and `vite.config.js`, copied to the host's project root.
- `deploy/assets/images/` — copied to the host's `public/images`.
- `deploy/color_palettes/` — copied to the host's `resources/color_palettes`.
- `deploy/.env.example` — copied to the host's `.env` and `.env.example`.

Edit these files when you want to change what gets scaffolded into a host app at install time — not to change the package's own runtime behavior.

### Dependency declarations

The composer and npm packages to be installed during installation, and the vendor:publish operations performed, are declared in `src/Traits/PackageTasksTrait.php` (used by the install command). Specifically:

- `$requiredNodePackages` — npm dependencies added to the host's `package.json`.
- `$phpDependencies` — composer packages required in the host.
- `$vendorPublish` — `vendor:publish` tags/providers run during install (dissemination config, dissemination migrations, Livewire config, Spatie permissions).

When a user asks to add, remove, or change a dependency that ships with the package, edit this trait — not `composer.json` (which is the package's own dev dependencies).

### Consequences for editing

- Don't expect `app/`, `routes/`, `database/migrations/` at the repo root — they don't exist. Package equivalents are under `src/` and `database/migrations/` (as `.stub` files).
- When editing a **view**, reference it as `dissemination::path.to.view`; find it under `resources/views/` here.
- When editing a **migration**, you're editing a `.php.stub` that a host app only picks up after re-publishing — mention this if a user expects the change to take effect in an existing host.
- When editing **config**, the host's published `config/dissemination.php` wins over the package's `config/dissemination.php`.
- There is **no `artisan` at the root**. Use `vendor/bin/testbench` for artisan-equivalents (e.g. `vendor/bin/testbench route:list`) and `vendor/bin/pest` for tests. See `composer.json` scripts: `composer test`, `composer lint`, `composer build`, `composer serve`, `composer analyse`.
- The `workbench/` directory is a dev-only skeleton for local serving/testing — it is **not** the host app and not where package code goes.

### Documentation site

The package's documentation lives in `docs/` and is built with [VitePress](https://vitepress.dev) (config at `docs/.vitepress/config.mts`). Content is organised into `docs/manager/` (admin/manager guide) and `docs/user/` (end-user guide), with `docs/index.md` as the landing page. npm scripts (in `package.json`): `npm run docs:dev` (local dev server), `npm run docs:build` (build static site to `docs/.vitepress/dist`), `npm run docs:preview` (preview the built site). Edit the Markdown files under `docs/` when updating documentation; do not edit generated output under `docs/.vitepress/cache` or `docs/.vitepress/dist`.

### Documentation sync stamp

The documentation was last reviewed and aligned with package release **1.12.0** (commit `292bc93`, 2026-06-19).

| Field | Value |
|---|---|
| Aligned at | `1.12.0` |
| Commit | `292bc93` |
| Date | 2026-06-19 |

To check whether docs have drifted from the package since this stamp, run:

```
git log 1.12.0..HEAD --oneline -- src/ routes/ resources/views/ config/ database/migrations/
```

Review each listed package change, update the relevant docs pages, then bump the stamp above to the latest release tag.

<!-- CODEGRAPH_START -->
## CodeGraph

In repositories indexed by CodeGraph (a `.codegraph/` directory exists at the repo root), reach for it BEFORE grep/find or reading files when you need to understand or locate code:

- **MCP tools** (when available): `codegraph_explore` answers most code questions in one call — the relevant symbols' verbatim source plus the call paths between them. `codegraph_node` returns one symbol's source + callers, or reads a whole file with line numbers. If the tools are listed but deferred, load them by name via tool search.
- **Shell** (always works): `codegraph explore "<symbol names or question>"` and `codegraph node <symbol-or-file>` print the same output.

If there is no `.codegraph/` directory, skip CodeGraph entirely — indexing is the user's decision.
<!-- CODEGRAPH_END -->
