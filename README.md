#QR-Reader

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

# Deploy 
- composer install
- npm install
- php artisan migrate
- php artisan db:seed --class=UserTableSeeder


## Credentials to acces Backend
- demo@mail.com
- 0987654321

