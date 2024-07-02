# Proyecto Memo


## Installation 
Make sure that you have setup the environment properly. You will need minimum PHP 8.1, MySQL/MariaDB, and composer.

1. Download the project (or clone using GIT).
2. Copy `.env.example` into `.env` and configure your database credentials y en DB_DATABASE poner memo.
3. Go to the project's root directory using terminal window/command prompt.
4. Run `composer install`.
5. Set the application key by running `php artisan key:generate --ansi`.
6. Correr 'npm install' y luego 'npm run build'.
7. Run migrations `php artisan migrate`.
8. Start local server by executing `php artisan serve`.
9. Visit here [http://127.0.0.1:8000](http://127.0.0.1:8000) to test the application.
