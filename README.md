# Laravel Project - Base App

This project is a base application in Laravel with functional authentication.
It includes a custom command to create the database, run migrations, and insert an initial user automatically.

---

## Prerequisites

- PHP 8.2 or higher
- Composer
- MySQL
- Laravel 12.x
- Node.js (optional, for asset compilation)
- An environment such as Laragon
- Kilo Code (AI used for development)

---

## Initial Setup

1. Clone the repository:

```bash
git clone <url-del-repo>
cd project-name
```

2. Install dependencies:

```bash
composer install
```

3. Verify the file `.env`.  
   Make sure the database connection is configured correctly:

```
APP_NAME=AppBase
DB_DATABASE=blog_db
DB_USERNAME=root
DB_PASSWORD=
```

If this is a new project, change `DB_DATABASE` to the appropriate name (e.g., `app_new_db`).

The database files (migrations, seeders, factories) are located in the `database/basedatos.sql/odontograma.sql` 

4. Generate the application key:

```bash
php artisan key:generate
```

5. Clear temporary cache and old configurations (not required when clone repository):

```bash
php artisan optimize:clear
# php artisan permission:cache-reset  #Cache for permissions
```

6. Create the symbolic link for storage:

```bash
php artisan storage:link
```

---

## Initialize the Project

Run the custom command:

```bash
php artisan setup:project
```

This command will perform the following actions:
1. Drop the current database (if it exists).
2. Recreate the database.
3. Run all migrations.
4. Insert an initial user

---
## Run the Server

```bash
php artisan serve
```

Open in the browser:
http://127.0.0.1:8000

Other way to open on browser using laragon
http://name-folder.test

---

## Access the System

- Email:    `pingo@gmail.com`  
- Password: `123456`

---

## Extra commands

- Check Laravel Version

```bash
laravel -V
```

- Check Composer Version

```bash
composer -V
```

- Rebuilds the autoload files in an optimized way, creating a full classmap.

```bash
composer dump-autoload -o
```

-  Start jobs on new terminal for download process

```bash
php artisan queue:work
```

---

## Issues with laragon

Open file: C:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\php.ini and find the name "extension=zip"

```bash
;extension=zip
```

Uncomment the line and should be this:

```bash
extension=zip
```