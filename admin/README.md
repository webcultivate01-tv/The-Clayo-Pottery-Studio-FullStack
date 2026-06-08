# Calyo Studio Management System — Admin Panel

PHP 8+ / MySQL MVC admin panel. **Phase 1** scope: foundation, authentication (sessions, CSRF, bcrypt, lockout, audit log), RBAC scaffolding, and an empty dashboard shell. Module CRUD (clients, leads, projects, etc.) is intentionally not yet implemented — those land in Phase 2.

## Stack

- PHP 8.1+ (tested target: XAMPP 8.2)
- MySQL 5.7+ / MariaDB 10.3+
- Tailwind CSS via CDN (no build step)
- No Composer / no vendor dependencies — pure PHP

## Folder structure

```
admin/
├── index.php                  # Front controller (only public PHP entry)
├── .htaccess                  # URL rewrites + security headers
├── config/
│   ├── app.php                # App config (base_path, session, security)
│   └── database.php           # PDO connection settings
├── core/                      # Mini framework (not user-editable)
│   ├── Bootstrap.php
│   ├── Autoloader.php
│   ├── App.php
│   ├── Database.php
│   ├── Router.php
│   ├── Request.php
│   ├── Response.php
│   ├── Session.php
│   ├── View.php
│   ├── Controller.php         # Base controller
│   ├── Model.php              # Base PDO model
│   └── Exceptions/HttpException.php
├── app/
│   ├── controllers/           # AuthController, DashboardController
│   ├── models/                # User
│   ├── services/              # AuthService (login attempt + audit)
│   ├── middleware/            # Auth, Guest, CSRF, Role, AdminOnly
│   ├── helpers/               # security.php, csrf.php, url.php (autoloaded)
│   └── views/                 # PHP templates + layouts + partials
├── routes/web.php             # Route definitions
├── database/
│   ├── schema.sql             # Full MySQL schema (10 modules)
│   └── seeds/
│       ├── create_admin.php   # CLI: create/reset admin user
│       └── generate_password_hash.php
├── storage/
│   ├── logs/                  # PHP error log target
│   └── uploads/               # File-module storage (Phase 2)
└── public/                    # Static asset target (Phase 2)
```

## Setup (XAMPP on Windows)

1. **Place the project under XAMPP's htdocs.** For example:
   `C:\xampp\htdocs\clayo-Studio-Management-System\`
   (If you keep it elsewhere, adjust `base_path` in [admin/config/app.php](config/app.php).)

2. **Start Apache and MySQL** from the XAMPP control panel.

3. **Create the database and tables.** In XAMPP shell or phpMyAdmin:
   ```
   "C:\xampp\mysql\bin\mysql.exe" -u root < admin\database\schema.sql
   ```
   Or open phpMyAdmin → Import → select `admin/database/schema.sql`.

4. **Configure DB credentials** if they differ from XAMPP defaults (root / no password).
   Edit [admin/config/database.php](config/database.php).

5. **Create the admin user.** From the project root in a terminal:
   ```
   "C:\xampp\php\php.exe" admin\database\seeds\create_admin.php
   ```
   Default credentials it sets:
   - Email: `admin@gmail.com`
   - Password: `admin123`

   To choose your own:
   ```
   "C:\xampp\php\php.exe" admin\database\seeds\create_admin.php --email=you@you.com --password=YourStrongPass
   ```

6. **Visit:** http://localhost/clayo-Studio-Management-System/admin/login

   Sign in with `admin@gmail.com` / `admin123` → redirected to the dashboard.

## Security model (Phase 1)

- **Sessions:** strict cookie flags (`HttpOnly`, `SameSite=Lax`), regenerated on login.
- **Passwords:** `password_hash` / `password_verify` with bcrypt cost 12.
- **CSRF:** all `POST` routes pass through `CsrfMiddleware`; views use `csrf_field()`.
- **XSS:** output escaped via `e()` helper; `X-XSS-Protection`, `X-Content-Type-Options`, `X-Frame-Options`, `Referrer-Policy` headers set in [.htaccess](.htaccess).
- **SQL injection:** all queries use PDO prepared statements (`PDO::ATTR_EMULATE_PREPARES = false`).
- **Brute force:** 5 failed attempts → 15-minute lockout (configurable in [config/app.php](config/app.php)).
- **RBAC:** `users.role` enum (`admin` / `staff`). Routes can require `AdminOnlyMiddleware`.
- **Audit log:** login success/failure/logout recorded in `audit_logs` with IP + user-agent.
- **Direct file access:** `.htaccess` blocks `app/`, `config/`, `core/`, `database/`, `storage/`, `routes/`.

## Adding a route (quick reference)

Edit [routes/web.php](routes/web.php):

```php
$router->get('/clients',  [ClientsController::class, 'index'], [AuthMiddleware::class]);
$router->post('/clients', [ClientsController::class, 'store'], [CsrfMiddleware::class, AuthMiddleware::class]);
```

URL params use `{name}` syntax — `/{id}` → `$controller->show(Request $r, string $id)`.

## What's NOT in Phase 1

The following are wired into the sidebar nav but their controllers/views are not yet implemented (clicking them returns 404 until Phase 2):

- Clients, Leads, Projects, Team, Files, Appointments, Notifications, Settings module CRUD
- Charts on the dashboard (placeholders only)
- File upload pipeline
- Email sending / SMTP
- Dark mode toggle

## Phase 2 (next)

When you're ready, the next phase implements one module at a time end-to-end (model → controller → views → routes), starting with **Clients** as the reference pattern.

## Troubleshooting

- **"Database connection failed"** → check [config/database.php](config/database.php) and that MySQL is running.
- **Blank page** → set `'debug' => true` in [config/app.php](config/app.php), then check `storage/logs/php-error.log`.
- **"CSRF token mismatch" (419)** → session likely expired; refresh the login page.
- **Forgot admin password** → re-run `create_admin.php` (it resets if the email exists).
- **Pretty URLs (no `index.php`) not working** → enable `mod_rewrite` in `httpd.conf` and ensure `AllowOverride All` for `htdocs`.
