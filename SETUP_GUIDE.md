# Project Setup Guide for Collaborators

## Prerequisites
Before starting, ensure you have installed:
- **Git** - https://git-scm.com/download/win
- **PHP 8.3+** - https://www.php.net/downloads
- **Composer** - https://getcomposer.org/download/
- **Node.js & npm** - https://nodejs.org/

---

## Step 1: Clone the Repository

Open your terminal/PowerShell and run:

```bash
git clone https://github.com/drian-src/POLIS.git
cd polis
```

---

## Step 2: Install PHP Dependencies

```bash
composer install
```

This will install all Laravel dependencies from `composer.json`.

---

## Step 3: Install Node Dependencies

```bash
npm install
```

This will install frontend dependencies (Vite, etc.).

---

## Step 4: Create Environment Configuration File

```bash
cp .env.example .env
```

Or on Windows PowerShell:
```powershell
Copy-Item .env.example .env
```

---

## Step 5: Generate Application Key

```bash
php artisan key:generate
```

This generates a unique encryption key for your application.

---

## Step 6: Configure Database Connection

Open `.env` file in your editor and update these lines with your Supabase credentials:

```env
DB_CONNECTION=pgsql
DB_HOST=db.mczaqooihnrcejmftqcy.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=your_supabase_password
```

**Get your Supabase credentials from:** https://supabase.com/dashboard

---

## Step 7: Enable Required PHP Extensions

Your `php.ini` file needs these extensions enabled:

1. **Locate your php.ini file:**
   ```bash
   php --ini
   ```

2. **Edit php.ini** and uncomment these lines:
   ```ini
   extension=mbstring
   extension=pdo_pgsql
   extension=pgsql
   ```

   Find these lines and remove the semicolon (`;`) at the beginning.

---

## Step 8: Run Database Migrations

```bash
php artisan migrate
```

This creates all necessary database tables in your Supabase PostgreSQL database.

---

## Step 9: (Optional) Seed the Database

If you want to populate sample data:

```bash
php artisan db:seed
```

---

## Step 10: Start the Development Server

Open two terminal windows:

### Terminal 1 - Start Laravel Server:
```bash
php artisan serve
```

You'll see:
```
Laravel development server started: http://127.0.0.1:8000
```

### Terminal 2 - Build Frontend Assets (Vite):
```bash
npm run dev
```

---

## Step 11: Access the Application

Open your browser and go to:
```
http://127.0.0.1:8000
```

---

## Troubleshooting

### Error: "Call to undefined function mb_split()"
- **Solution:** Make sure `extension=mbstring` is enabled in php.ini

### Error: "could not find driver (Connection: pgsql)"
- **Solution:** Make sure `extension=pdo_pgsql` and `extension=pgsql` are enabled in php.ini

### Error: "SQLSTATE[28P01] role \"postgres\" does not exist"
- **Solution:** Check your DB_USERNAME and DB_PASSWORD in .env match your Supabase credentials

### Permission denied or cannot write to storage/
- **Solution:** Ensure the `storage/` and `bootstrap/cache/` directories are writable:
  ```bash
  chmod -R 755 storage bootstrap/cache
  ```

### Composer install fails
- **Solution:** Make sure you have the latest Composer version:
  ```bash
  composer self-update
  ```

---

## Project Structure

```
polis/
├── app/              # Application code
├── bootstrap/        # Bootstrap files
├── config/           # Configuration files
├── database/         # Migrations, seeders, factories
├── public/           # Public assets (entry point)
├── resources/        # Views, CSS, JavaScript
├── routes/           # Route definitions
├── storage/          # Logs, cache, uploads
├── tests/            # Test files
├── vendor/           # Composer dependencies
├── node_modules/     # npm dependencies
├── .env.example      # Example environment file
├── composer.json     # PHP dependencies
└── package.json      # Node dependencies
```

---

## Useful Commands

```bash
# Run artisan commands
php artisan list                    # See all available commands

# Database
php artisan migrate:rollback        # Rollback last migration
php artisan migrate:refresh         # Rollback and re-run all migrations
php artisan tinker                  # Interactive shell

# Clearing cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Building assets
npm run build                       # Production build
npm run dev                         # Development with hot reload
```

---

## Questions?

If you encounter any issues, check:
1. PHP version: `php --version` (should be 8.3+)
2. Composer version: `composer --version`
3. Node version: `node --version`
4. Database connection in `.env`
5. PHP extensions are enabled

Good luck! 🚀
