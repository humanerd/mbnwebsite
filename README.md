# Mobile Business Network (MBN) Website

Production-minded PHP 8.2+ MVC-style website for Mobile Business Network.

## Architecture

- `public/` web root and static assets.
- `app/Core/` bootstrap, routing, request/response, auth, CSRF, validation.
- `app/Controllers/` page, application, admin, and system controllers.
- `app/Models/` data access via prepared statements.
- `app/Views/` server-rendered templates, layouts, components, admin views.
- `config/` app + SEO configuration.
- `database/` schema and seed SQL.
- `storage/logs/` runtime logs.

## Setup

1. Copy environment file:
   ```bash
   cp .env.example .env
   ```
2. Create MySQL database and import schema:
   ```bash
   mysql -u root -p mbn < database/schema.sql
   mysql -u root -p mbn < database/seed.sql
   ```
3. Serve locally:
   ```bash
   php -S localhost:8000 -t public
   ```
4. Admin login (seed):
   - Email: `admin@mbn.local`
   - Password: `ChangeMe123!`

## Security and operations

- Prepared statements for all DB writes/reads.
- Escaped output with helper `e()`.
- CSRF token protection for application and admin forms.
- Honeypot + session rate limiting on application and admin login endpoints.
- Session hardening (httpOnly, sameSite, secure when HTTPS).

## SEO implementation

- Per-page title and meta description.
- Canonical URL tags.
- Open Graph + Twitter card tags.
- Organization and WebSite schema globally.
- FAQ schema on relevant pages.
- Dynamic `sitemap.xml` and `robots.txt` routes.
- SEO-friendly slug URLs and internal links.

## Where to edit copy

- Main public copy pages: `app/Views/pages/*.php`
- Reusable global CTA: `app/Views/components/cta.php`
- Hero patterns: `app/Views/components/hero.php`
- Header/footer navigation copy: `app/Views/components/header.php`, `app/Views/components/footer.php`

## Notes

- To add a future vertical, create a page in `app/Views/pages`, add route in `app/Core/App.php`, and include link in `available-businesses.php`.
- Mail notifications use PHP `mail()` when `MAIL_ENABLED=true`.
