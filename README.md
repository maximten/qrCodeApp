# Qr code generation service
## Setup
Copy ``.env.example`` to ``.env`` file  
Start docker containers:  
``` docker-compose up ```  
Enter ``php-fpm`` container:  
``` docker-compose exec php-fpm bash ```  
Install composer dependencies:  
``` composer install ```  
Run database migrations:  
``` php artisan migrate --seed ```  
Link storage:  
``` php artisan storage:link ```  
## Tests
``` ./vendor/bin/phpunit ```  
## Api
```
POST     | api/qr/generate      | create entry and generate qr code with link to this entry
PUT      | api/qr/status/{hash} | update entry status 
GET      | api/qr/{hash}        | get entry data  
```