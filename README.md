# QR-Reader
- State Pattern : Submitted, onProcessing, Processed
- file's table: System should store the file name, timestamp, status and the content of the qr code.

## Packages Used 
- Dropzone for file upload: https://docs.dropzone.dev/
- https://symfony.com/doc/current/components/process.html

#Enable local enviroment
- Copy .env.example to .env file
- sail artisan sail:publish

# Enable poppler-util on server
To image generation we will use poppler-utils this library was prepiusly added over Dockerfile
- file: /docker/8.1/Dockerfile
```
    && apt-get install -y poppler-utils \
```

# Auth
```
composer require laravel/breeze --dev
php artisan breeze:install
php artisan migrate
```
# Laravel-model-sates
https://github.com/spatie/laravel-model-states


# Deploy 
- composer install
- npm install
- php artisan migrate
- php artisan db:seed --class=UserTableSeeder


## Credentials to acces Backend
- demo@mail.com
- 0987654321

