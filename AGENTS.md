# AGENTS.md — Statamic Color Swatches

## Project Overview

Statamic addon providing a "Color Swatches" fieldtype. Users configure named colors (with one or more CSS values each) in the field config, and the fieldtype renders clickable swatch buttons in the CP. The stored value is `{ label: string, value: string[] }`.

**Stack:** PHP 8+ / Laravel / Statamic v6, Vue 2 (Options API via Statamic CP), Vite, CSS.

## Repository Structure

```
src/
  ServiceProvider.php          # AddonServiceProvider — registers fieldtype + GraphQL type
  ColorSwatchesFieldtype.php   # Fieldtype (config schema, process, augment, GraphQL bridge)
  GraphQL/
    ColorSwatchType.php        # Rebing\GraphQL type for label + value
resources/
  js/
    color-swatches.js                  # Entry — registers Vue components with Statamic
    ColorSwatchesFieldtype.vue         # CP edit component (mixin: Fieldtype)
    ColorSwatchesFieldtypeIndex.vue    # CP index/listing component (mixin: IndexFieldtype)
    createCssBackgroundFromColors.js   # Utility — builds linear-gradient from color array
  css/
    color-swatches.css                 # Swatch button styles
dist/                                  # Vite build output (committed for distribution)
vite.config.js                         # Vite config with laravel, vue, externals plugins
```

## Build & Dev Commands

### PHP / Backend

```bash
# No PHPUnit tests exist in this repo. If adding tests:
composer test                         # (add script to composer.json)
vendor/bin/phpunit                    # Run all tests
vendor/bin/phpunit --filter=TestName  # Run a single test
vendor/bin/phpunit tests/Unit/ColorSwatchesFieldtypeTest.php  # Single file
```

No PHP linting/static analysis tools are currently configured. If adding:

```bash
vendor/bin/pint                       # Laravel Pint (code style)
vendor/bin/phpstan analyse            # Static analysis
```

### JavaScript / Frontend

```bash
npm install                   # Install JS dependencies
npm run dev                   # Start Vite dev server (HMR disabled)
npm run build                 # Production build → dist/
npm run format                # Prettier on resources/**/*.{css,js,json,ts,tsx,vue}
```

## Code Style — PHP

### General

- Follow PSR-12 and Spatie Laravel conventions.
- Use strict types where possible.
- Namespace: `Rias\ColorSwatches` — PSR-4 autoloaded from `src/`.

### Imports & Namespaces

- One `use` statement per class, alphabetically sorted.
- Prefer facade imports from `Statamic\Facades\*` for Statamic APIs.
- Import Laravel helpers from `Illuminate\Support\*`.

```php
use Illuminate\Support\Arr;
use Statamic\Facades\GraphQL;
use Statamic\Fields\Fieldtype;
```

### Naming

- **Classes:** PascalCase — `ColorSwatchesFieldtype`, `ColorSwatchType`.
- **Methods:** camelCase — `toGqlType()`, `bootAddon()`.
- **Properties:** camelCase, `$configFields`, `$fieldtypes`.
- **Constants:** UPPER_SNAKE_CASE.

### Class Structure (Spatie order)

1. Traits
2. Constants
3. Static properties
4. Properties (public → protected → private)
5. Constructor
6. Static methods
7. Public methods
8. Protected methods
9. Private methods

### Types & Return Types

- Always declare return types on public methods.
- Use PHP 8 features: union types, named arguments, match expressions where clearer.

### Error Handling

- Use early returns / guard clauses to reduce nesting.
- Validate data existence with `isset()` before accessing array keys (see `process()` method).

### Formatting

- Array alignment: config arrays use padded `=>` for readability (see `$configFields`).
- Opening braces on same line for classes and methods.
- Blank line between method definitions.

## Code Style — JavaScript / Vue

### General

- Prettier for formatting (run `npm run format`).
- Vue 2 Options API with Statamic mixins (`Fieldtype`, `IndexFieldtype`).
- Import from `@statamic/components/fieldtypes/` for CP base mixins.

### Vue Components

- Use `.vue` single-file components with `<template>`, `<script>` sections.
- Mixin pattern: `mixins: [Fieldtype]` or `mixins: [IndexFieldtype]`.
- Use `this.update(value)` to emit fieldtype value changes (from Fieldtype mixin).
- Use `this.value` and `this.config` from the mixin — do not redeclare as props/data.

### Component Registration

Components are registered in `color-swatches.js` via:

```js
Statamic.booting(() => {
  Statamic.$components.register("color_swatches-fieldtype", Component);
});
```

Naming convention: `{handle}-fieldtype` and `{handle}-fieldtype-index`.

### Imports

- Relative imports for local files: `./createCssBackgroundFromColors`.
- Aliased imports for Statamic internals: `@statamic/components/...`.

### Functions

- Prefer `function` keyword for standalone utility functions (see `createCssBackgroundFromColors`).
- Use method shorthand in Vue component `methods` and `computed` blocks.

### Naming

- **Files:** PascalCase for Vue components, camelCase for JS utilities.
- **Functions/methods:** camelCase.
- **CSS classes:** kebab-case, prefixed with `color-swatches-`.
- **Fieldtype CSS wrapper:** `.color_swatches-fieldtype` (auto-generated by Statamic).

## CSS

- Scoped to `.color_swatches-fieldtype` wrapper (Statamic auto-wraps fieldtypes).
- Use CSS custom properties (`var(--color-zinc-800)`) from Statamic's design system.
- Use Tailwind utility classes in Vue templates where appropriate (`w-4 h-4 rounded-full`).

## Vite Configuration

- Entry points: `resources/js/color-swatches.js` + `resources/css/color-swatches.css`.
- Output: `dist/` directory (committed, used by Composer distribution).
- Vue and Pinia are externalized (provided by Statamic CP runtime).
- HMR is disabled (`server.hmr: false`).
- Uses `laravel-vite-plugin` + Statamic's custom vite plugin.

## Statamic Addon Conventions

- `ServiceProvider` extends `AddonServiceProvider`.
- Register fieldtypes via `$fieldtypes` property.
- Register Vite assets via `$vite` property with `input`, `publicDirectory`, `hotFile`.
- GraphQL types added in `bootAddon()` via `GraphQL::addType()`.
- Fieldtype handle derived from class name: `ColorSwatchesFieldtype` → `color_swatches`.

## Data Shape

The fieldtype stores and returns:

```json
{
  "label": "Primary Blue",
  "value": ["#0066cc"]
}
```

- `value` can be a single string or array of CSS color strings.
- `process()` converts comma-separated string values to arrays.
- `augment()` passes through as-is.
- GraphQL resolves `value` to the first color string via `Arr::first()`.
