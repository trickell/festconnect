---
description: How to deploy the FestConnect application to a new web server
---

# Deployment Workflow

Follow these steps to deploy the application on a new server after cloning the repository.

### 1. Install Dependencies
Run these commands to install PHP and JavaScript dependencies.

```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
```

### 2. Environment Configuration
Copy the default environment file and generate a unique application key.

```bash
cp .env.example .env
php artisan key:generate
```

> [!IMPORTANT]
> Edit the `.env` file to configure your database credentials, mail server, and `APP_URL`.

### 3. Database Setup
Run the migrations and seeders to set up the database schema and the initial beta invite codes.

```bash
php artisan migrate --force
php artisan db:seed --class=BetaInviteSeeder
```

### 4. File Permissions
Ensure the web server has write access to the storage and cache directories.

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data . # Or appropriate web server user
```

### 5. Optimization
Cache the configuration, routes, and views for better performance.

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 6. Web Server Config
Configure Nginx or Apache to point to the `public/` directory as the document root.
Example for Nginx:
```nginx
root /var/www/festconnect/public;
index index.php;
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```
