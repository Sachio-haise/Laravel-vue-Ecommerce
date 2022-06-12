## set_up

-   composer install
-   cp .env.example .env
-   php artisan key:generate
-   php artisan migrate

## dataBase_seeding

-   php artisan db:seed --class=testEnvSeeder
-   php artisan passport:install

## api_routes

-   login_route - /api/auth/login
-   register_route - /api/auth/register
-   email_verify route - /api/auth/email-verify
-   token_scope route - /api/auth/login
