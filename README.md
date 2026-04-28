# Others Accounts

A Laravel 12 application for managing accounts and receive entries with AJAX-powered modals, DataTable lists, validation, and invoice number auto-generation.

## Features

- User authentication with login and registration
- Admin-protected dashboard and settings pages
- Accounts management module
  - Create, edit, delete accounts
  - Server-side DataTable listing with search, sort, and pagination
  - Duplicate account validation by name and sector
- Receive entry module
  - Create, edit, delete receives
  - Auto-generate next invoice number
  - Account selection for receives
  - Server-side DataTable listing with search, sort, pagination, and remarks preview
- AJAX modal forms for create/edit operations
- Responsive Laravel Blade layout with reusable components

## Project Structure

- `app/Http/Controllers/` — application controllers
- `app/Models/` — Eloquent models such as `Account`, `Receive`, and `User`
- `resources/views/` — Blade templates and modal views
- `routes/web.php` — web routes and middleware configuration
- `database/migrations/` — database schema definitions
- `public/` — frontend assets and compiled files

## Requirements

- PHP 8.2+
- Composer
- Node.js + npm
- MySQL or compatible database

## Setup

1. Clone the repository
2. Install PHP dependencies
   ```bash
   composer install
   ```
3. Create the environment file
   ```bash
   cp .env.example .env
   ```
4. Generate the application key
   ```bash
   php artisan key:generate
   ```
5. Configure database settings in `.env`
6. Run migrations
   ```bash
   php artisan migrate
   ```
7. Install frontend dependencies
   ```bash
   npm install
   ```
8. Build assets
   ```bash
   npm run build
   ```
9. Start the server
   ```bash
   php artisan serve
   ```

## Available Routes

Key application routes include:

- `GET /login` — login page
- `GET /register` — registration page
- `GET /dashboard` — admin dashboard
- `GET /accountSetupView` — account setup page
- `GET /receiveView` — receive management page
- `GET /accounts/create` — account create modal
- `GET /accounts/{id}/edit` — account edit modal
- `GET /receives/create` — receive create modal
- `GET /receives/{id}/edit` — receive edit modal
- `GET /receives/last-invoice` — fetch next invoice number

## Notes

- All account and receive management routes are protected by `auth` and `LsValidUser:admin` middleware.
- The application uses AJAX requests to load modal forms and perform create/update/delete actions without full page reloads.

## Testing

Run the Laravel test suite:

```bash
php artisan test
```

## License

This project is open-sourced software licensed under the MIT license.
