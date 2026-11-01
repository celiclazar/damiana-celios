# Celios Starter

Application skeleton for creating client projects using Celios CMS.

## Requirements

- PHP 8.3 or higher
- Composer
- Node.js and NPM
- MySQL, PostgreSQL, or SQLite database

## Setup Instructions

1. Clone this repository for your new client project:
   git clone git@github.com:celiclazar/celios-starter.git project-name
   cd project-name

2. Point the Git remote to the new client repository:
   git remote set-url origin git@github.com:celiclazar/new-client-repo.git

3. Install PHP dependencies:
   composer install

4. Create the environment file:
   cp .env.example .env
   php artisan key:generate

5. Configure database credentials in `.env`:
   Set your DB_CONNECTION, DB_HOST, DB_DATABASE, DB_USERNAME, and DB_PASSWORD values.

6. Run the Celios installer:
   php artisan celios:install

   This command will publish configurations, run database migrations, create the storage symlink, and prompt you to create the initial Superadmin user.

7. Seed mandatory system pages (Home, Terms & Conditions, Privacy Policy, Cookie Policy):
   php artisan db:seed

8. Install and build frontend assets:
   npm install
   npm run build

9. Commit and push the project to your client repository:
   git push -u origin main

## Accessing the Admin Panel

Start the local server:
php artisan serve

Navigate to:
http://localhost:8000/admin

Log in with the Superadmin credentials created in step 6.

## Updating Celios Core

When an update or bug fix is released for Celios Core:

1. Update packages:
   composer update celios/*

2. Run any new migrations:
   php artisan migrate

3. Commit the updated composer.lock file to the client repository:
   git commit -am "chore: update celios core"
   git push origin main
