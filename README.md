# QR-Reader
- Submitted, onProcessing, Processed
- file's table: System should store the file name, timestamp, status and the content of the qr code.
- Queue Jobs background for image generation and QR iteration (database)

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
## Credentials to access Backend
```
- http://localhost/
- demo@mail.com
- 0987654321
```

## Jobs description
- ProcessDocument:  run PDFTOCAIRO command with SYMPHONY-PROCESS library
- QRImageScanJob :  iterate document folder and run shell script by using SYMPHONY-PROCESS library, this terminal process will generate a plan text file with QRCode if it was found.
- QRCodeStoreJob :  read result.txt file , extract content and store data over Document record

## Packages Used 
- Dropzone for file upload: https://docs.dropzone.dev/
- To run console commands (phptocairo, bash scripts) https://symfony.com/doc/current/components/process.html
- https://sourceforge.net/projects/zbar/

Convert PDF to images peer page
```
    $ pdftocairo document.pdf -png 
```

Validate image has QRcode and store result on txt file
```
     zbarimg image.png >> result.txt
```

 # Enable additional packages on Docker file

- file: /docker/8.1/Dockerfile
```
    && apt-get install -y poppler-utils \
    && apt-get install -y zbar-tools \   
```

# Laravel-model-sates TODO
https://github.com/spatie/laravel-model-states



