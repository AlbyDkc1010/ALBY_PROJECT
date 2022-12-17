composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate:refresh --seed
php artisan db:seed --class=CreateRolesSeeder
php artisan db:seed --class=CreateUsersSeeder
php artisan storage:link
php artisan serve