# Project Instructions

## Role and Product Context
- Work as a senior front-end engineer with deep user-experience expertise: understand the user's task, prioritize clear workflows, and make deliberate, testable interface decisions.
- This Laravel app serves Indonesian used-car shoppers, showroom partners, and administrators managing vehicle inventory, imports, and photos. Tailor the interaction and information hierarchy to each audience.
- Keep customer-facing copy in Indonesian when consistent with the surrounding page.

## Front-End Stack and Boundaries
- The interface is primarily Laravel Blade, styled with Tailwind utilities, built through Vite, and uses Alpine.js for lightweight interactivity. Main asset entries are `resources/css/app.css` and `resources/js/app.js`.
- Inspect the target page and its route/controller before changing behavior. Preserve Laravel route names, form methods, CSRF protection, authorization assumptions, and validation/error flows.
- Layouts are mixed: many admin pages extend `resources/views/layouts/admin.blade.php`, some public pages use `resources/views/layouts/app.blade.php`, and several catalog, login, or showroom pages are standalone. Follow the target page's current shell; do not assume a shared layout change affects every screen.
- Reuse existing Blade components where appropriate. Keep JavaScript small and use Alpine for local UI state; avoid adding dependencies or new CDN assets without a concrete need.
- `README.md` is the stock Laravel starter README, not reliable product documentation. Use nearby routes, controllers, views, and configuration as the source of project-specific behavior.
- Tailwind configuration needs care: `package.json` declares Tailwind 3 and `@tailwindcss/vite` 4, while `tailwind.config.js` and `resources/css/app.css` follow Tailwind 3 conventions. Verify the installed build behavior before changing the CSS pipeline; do not perform a version migration as incidental cleanup.

## UX and Visual Quality
- Preserve the established Gratama visual identity where it exists: maroon (`#800000`), Plus Jakarta Sans, and restrained slate/white surfaces. Keep page-specific variations unless the task calls for a wider redesign.
- Optimize operational screens for scanning and repeated work: clear hierarchy, readable tables, visible statuses, concise actions, and useful empty, loading, success, and error states.
- Make every workflow usable on narrow screens and with keyboard navigation. Use semantic headings, labels, buttons/links, table headers, visible focus states, sufficient contrast, and meaningful accessible names.
- Prefer readable type and touch-friendly controls. Do not copy tiny text, ambiguous icon-only actions, decorative complexity, or duplicated shell markup merely because they exist on a neighboring page.
- Keep changes scoped to the requested experience. Avoid changing backend contracts or redesigning unrelated screens; call out any UX issue that cannot be fixed without a broader change.

## Verification
- Run `npm run build` after front-end asset or Blade class changes when feasible.
- Run `php artisan test` for behavior changes; `composer run test` is the configured equivalent with cache clearing.
- PHPUnit is configured to use an in-memory SQLite database. Do not assume the local `.env` database settings match the test environment.
- Tests currently provide limited coverage for UI workflows. For user-facing changes, also inspect the affected page at desktop and mobile widths and exercise its main interaction and error/empty states when the environment allows.