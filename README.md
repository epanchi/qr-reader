#QR-Reader

#Enable local enviroment
- Copy .env.example to .env file
- sail artisan sail:publish

# Enable poppler-utils 
To image generation we will use poppler-utils this library was prepiusly added over Dockerfile
- file: /docker/8.1/Dockerfile
```
    && apt-get install -y poppler-utils \
```
