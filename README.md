# PHP Auth Starter Kit

A production-ready PHP authentication template with everything you need to get going. Clone it, configure it, build on it.

## What's Included

- Email/password registration and login
- Password reset via email (SMTP through PHPMailer)
- TOTP-based two-factor authentication (Google Authenticator, Authy, etc.)
- CSRF protection on all forms
- Rate limiting (login, registration, password reset)
- Secure session handling with fingerprinting
- Audit logging (logins, failed attempts, password changes, 2FA events)
- Remember me / persistent login tokens
- Account lockout after repeated failures
- Clean UI inspired by modern glassmorphism design

## Requirements

- PHP 8.1+
- MySQL 5.7+ (or MariaDB)
- Composer

## Quick Start

```bash
git clone https://github.com/yourname/php-auth-starter-kit.git myproject
cd myproject
composer install
```

Open `config/app.php` and fill in your database and SMTP credentials:

```php
'db' => [
    'host' => 'localhost',
    'port' => 3306,
    'name' => 'your_dbname',      // create in cPanel → MySQL Databases
    'user' => 'your_dbuser',      // create in cPanel → MySQL Databases
    'pass' => 'your_dbpassword',  // set in cPanel → MySQL Databases
],

'smtp' => [
    'host' => 'smtp.gmail.com',
    'port' => 587,
    'user' => 'you@gmail.com',
    'pass' => 'your-app-password',
    ...
],
```

Then run the migration to create all tables:

```bash
php migrations/migrate.php
```

Point your web server's document root to the `public/` directory, or use the built-in server for local dev:

```bash
php -S localhost:8000 -t public
```

Visit `http://localhost:8000` and you're in business.

## cPanel Deployment

1. Upload all files to your hosting (above `public_html`)
2. In cPanel → MySQL Databases, create a database and user, then add the user to the database with ALL PRIVILEGES
3. Edit `config/app.php` with your credentials
4. Point your domain's document root to the `public/` folder (or move `public/` contents into `public_html` and adjust paths in `index.php`)
5. SSH in and run `php migrations/migrate.php`, or import the SQL manually
6. Done

## Project Structure

```
├── config/app.php      ← your DB + SMTP credentials go here
├── migrations/         ← database migration script
├── public/             ← web root (index.php, assets)
│   └── assets/
│       ├── css/
│       ├── js/
│       └── img/
├── src/
│   ├── Auth/           ← login, register, 2FA, reset, audit log
│   ├── Database/       ← PDO wrapper
│   ├── Mail/           ← PHPMailer integration
│   ├── Middleware/      ← CSRF, rate limiting, auth guards
│   └── Session/        ← session management
├── templates/          ← PHP view templates
│   ├── auth/           ← login, register, reset, 2FA views
│   ├── dashboard/      ← protected pages
│   └── layouts/        ← base layouts
├── logs/
├── storage/sessions/
├── composer.json
└── README.md
```

## Security Notes

- Passwords hashed with bcrypt (cost 12)
- Sessions regenerated on login and privilege escalation
- CSRF tokens validated on every POST request
- Rate limiting uses a sliding window per IP
- Remember-me tokens stored hashed, never in plaintext
- 2FA secrets encrypted at rest with AES-256
- All auth events written to the audit log
- Account lockout after 5 failed login attempts

## Extending

This is meant to be a starting point. Some ideas:

- Add OAuth providers (Google, GitHub, etc.)
- Plug in your own mailer templates
- Add roles and permissions
- Integrate with your frontend framework of choice

## License

MIT
