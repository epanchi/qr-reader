# QR-Reader
- Submitted, onProcessing, Processed
- file's table: System should store the file name, timestamp, status and the content of the qr code.
- Queue Jobs background for image generation and QR iteration (database)
- Docker intalled

# Enable application
Needs Docker installed in dev computer

After that fist time run following command, it will download and install all components to get the first instance of this application
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs

```

After compleattly resources were provisioned, tun the following commands (1) run dev server (2) run migrations (3) run user Seeder (4) Enable Queue

```
$ ./vendor/bin/sail up
$ ./vendor/bin/sail php artisan migrate
$ ./vendor/bin/sail php artisan db:seed --class=UserTableSeeder
$ ./vendor/bin/sail php artisan queue:work 

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
- To run console commands phptocairo, bash scripts) https://symfony.com/doc/current/components/process.html
- To read images and detect QRCodes https://sourceforge.net/projects/zbar/

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
https://robertogallea.com/posts/development/state-pattern-implementation-of-finite-state-machine-fsm-with-laravel



