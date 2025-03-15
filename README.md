
# DevPM - Laravel Project Setup

This guide will help you set up and run the Laravel project, including running database migrations and seeders.

---

## Prerequisites

Before running the project, ensure you have the following installed:

- **PHP** (>= 8.0 recommended)
- **Composer** ([Download Composer](https://getcomposer.org/download/))
- **Laravel Installer** (optional, but recommended)
- **Database Server** (MySQL, PostgreSQL, SQLite, etc.)
- **Node.js & npm** (for frontend assets if applicable)
- **vueJS 3** (for frontend assets if applicable)

---

# Run migrations
- php artisan migrate

# Run seeders
- php artisan db:seed --class=DatabaseSeeder
- php artisan db:seed --class=RolePermissionSeeder

# Run servers
- php artisan serve
- cd frontend && npm run dev
