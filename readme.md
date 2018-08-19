# Softnauts

## Installation
```bash
git clone https://github.com/MasterYarick/softnauts.git
cd softnauts
composer install
cp .env.example .env
php artisan key:generate
# Fill MySQL or PostgreSQL database credentials in .env file
php artisan migrate --seed
php artisan serve --host=localhost --port=8080
# Navigate to http://localhost:8080
```

## Description
Project is created with Laravel - The PHP Framework.
I used standards PSR.
I did with REST API in the convention Laravel.
