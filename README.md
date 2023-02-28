## Locals RESTful API

### Local deployment:
Make sure that you have installed last Docker version (https://docs.docker.com/install/). Clone current repository and do the following steps:
```sh
# Copy `.env.dist` to `.env` in the project root directory.
$ docker-compose build
$ docker-compose up
$ docker-compose exec php bash
```
Inside PHP container install dependencies and update database scheme with following command:
```sh
$ composer install -o
$ bin/console doc:dat:drop --force
$ bin/console doc:dat:create
$ bin/console doc:mig:mig
$ bin/console doc:fix:load
```
Project will be available on http://127.0.0.1:8001. Also you can use PHPMyAdmin - http://127.0.0.1:8080. For testing email sending use MailCatcher http://127.0.0.1:1080.

### JWT configuration:
This project uses LexikJWTAuthenticationBundle (https://github.com/lexik/LexikJWTAuthenticationBundle). For accessing API endpoints you have to generate keys:

```sh
$ mkdir config/jwt
$ openssl genrsa -out config/jwt/private.pem -aes256 4096
$ openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```
During keys generation you will be asked about passphrase. Don't forget add this passphrase to `.env` file. After that all routes with /api prefix will require Bearer token.