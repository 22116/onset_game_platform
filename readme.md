Mintme
======

Mintme panel, exchange platform that allow users to create and exchange their own tokens built on Webchain.

Getting started
---------------

Application written in SPA architecture, so there are 2 endpoints of project: `web` and `api`.
<br>API is a REST server written with Symfony 4.1, it handles all business logic.
<br>WEB is a VueJs client, which provides user GUI.

Prerequisites
-------------

* PHP ^7.2 & Composer
* NodeJs 8+ & NPM 5.6+
* MySql
* openssl library

Installing
----------
API:
```$xslt
#Go to API root directory
$ cd ./api
#Install deps. Add --no-dev option in production
composer install
$ php bin/console migrations:migrate --allow-no-migration -n
#Generate RSA keys for JWT tokens. This step can be skiped in development, as there are already provided some test keys
$ mkdir -p config/jwt
$ openssl genrsa -out config/jwt/private.pem -aes256 4096
$ openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```
Now you *must* to copy `.env.dist` file to `.env` and fill it with your data.<br>
In production this data *must* be set in environment.<br>

Configure [your](https://symfony.com/doc/current/setup/web_server_configuration.html#content_wrapper) webserver to pass all requests to the `public/app.php` file.
 In dev environment you can just run [Symfony's](https://symfony.com/doc/current/setup/built_in_web_server.html) webserver via `server:start` console command;

WEB:
Copy `.env.example` to `.env` and fill with your data.<br>
In production this data *should* be set in environment.<br>
```$xslt
#Go to WEB root directory
$ cd ./web
#Install deps
$ npm i
#Build application
$ npm run build
```

For development purposes you can run webserver with the next command: `npm run serve`

Running the test
----------------

//TODO

Deployment
----------

//TODO