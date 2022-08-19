# QR-Reader
- Submitted, onProcessing, Processed
- file's table: System should store the file name, timestamp, status and the content of the qr code.
- Queue Jobs background for image generation and QR iteration

# Enable application Docker Laravel Sail

```
$ ./vendor/bin/sail up 
$ ./vendor/bin/sail sell
```

Shell server console
```
/var/www/html$  composer install 
/var/www/html$  npm install
/var/www/html$  php artisan migrate

/var/www/html$  php artisan db:seed --class=UserTableSeeder

/var/www/html$  php artisan queue:work 

sail@988ef21636bd:/var/www/html$
```
## Credentials to acces Backend
```
- http://localhost/
- demo@mail.com
- 0987654321
```
## Packages Used 
- Dropzone for file upload: https://docs.dropzone.dev/
- To run console commands (phptocairo) https://symfony.com/doc/current/components/process.html
- https://github.com/khanamiryan/php-qrcode-detector-decoder
- https://sourceforge.net/projects/zbar/

```
    && apt-get install -y poppler-utils \
    && apt-get install -y zbar-tools \   
```

Running code
```
    $ pdftocairo document.pdf -png 
    $ 
```

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




