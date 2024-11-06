# Run Project Localy

This guide helps you set up and run the Laravel project after cloning it from GitHub.

## Prerequisites

Ensure you have the following installed:
- PHP (8.0+)
- Composer
- MySQL or another Laravel-compatible database
- Git

## Installation Steps

**Clone the Project**: Clone the repository to your machine:

   ```bash
   git clone git@github.com:IGedeMiarta/assignment-laravel-todo.git
   ```
**Install PHP Dependencies**: Run Composer to install dependencies:

   ```bash
   composer install
   ```
Set Up Environment Variables: Copy `.env.example` to `.env`:
   ```bash
   cp .env.example .env
   ```
Then, update `.env` with your settings:

   ```bash
   APP_NAME="Your Application Name"
   APP_URL=http://localhost
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_database_password
   ```

**Generate App Key**: Create an application key for encryption:

```bash
php artisan key:generate
```

**Run Migrations**: run database migrations:
```bash
php artisan migrate
```

**Start the Laravel Server**: Run the development server:
```bash
php artisan serve
```







# Filament admin

to make admin data. first, make filament user by run:
```bash
php artisan make:filament-user
```

and now you can login admin by in `/admin`
example:
```bash
localhost:8000/admin/login
```








## API Documentation

by running project, in url `/` you should have api Documentation buil with swagger.



## Authors
I Gede Miarta Yasa
- [Github](https://github.com/IGedeMiarta)
- [Whatsapp](wa.me/6281529963914)
