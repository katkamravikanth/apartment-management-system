# Apartment Management System [![Build Status](https://travis-ci.org/nanoninja/docker-nginx-php-mysql.svg?branch=master)](https://travis-ci.org/nanoninja/docker-nginx-php-mysql) [![GitHub version](https://badge.fury.io/gh/nanoninja%2Fdocker-nginx-php-mysql.svg)](https://badge.fury.io/gh/nanoninja%2Fdocker-nginx-php-mysql)

Docker running Nginx, PHP-FPM, Composer, MySQL and PHPMyAdmin.

## Overview

1. [Install prerequisites](#install-prerequisites)

   Before installing project make sure the following prerequisites have been met.

2. [Clone the project](#clone-the-project)

   We’ll download the code from its repository on GitHub.

3. [Configure Nginx With SSL Certificates](#configure-nginx-with-ssl-certificates) [`Optional`]

   We'll generate and configure SSL certificate for nginx before running server.

4. [Configure Xdebug](#configure-xdebug) [`Optional`]

   We'll configure Xdebug for IDE (PHPStorm or Netbeans).

5. [Run the application](#run-the-application)

   By this point we’ll have all the project pieces in place.

6. [Use Makefile](#use-makefile) [`Optional`]

   When developing, you can use `Makefile` for doing recurrent operations.

7. [Use Docker Commands](#use-docker-commands)

   When running, you can use docker commands for doing recurrent operations.

---

## Install prerequisites

To run the docker commands without using **sudo** you must add the **docker** group to **your-user**:

```
sudo usermod -aG docker your-user
```

For now, this project has been mainly created for Unix `(Linux/MacOS)`. Perhaps it could work on Windows.

All requisites should be available for your distribution. The most important are :

- [Git](https://git-scm.com/downloads)
- [Docker](https://docs.docker.com/engine/installation/)
- [Docker Compose](https://docs.docker.com/compose/install/)

Check if `docker-compose` is already installed by entering the following command :

```sh
which docker-compose
```

Check Docker Compose compatibility :

- [Compose file version 3 reference](https://docs.docker.com/compose/compose-file/)

The following is optional but makes life more enjoyable :

```sh
which make
```

On Ubuntu and Debian these are available in the meta-package build-essential. On other distributions, you may need to install the GNU C++ compiler separately.

```sh
sudo apt install build-essential
```

### Images to use

- [Nginx](https://hub.docker.com/_/nginx/)
- [MySQL](https://hub.docker.com/_/mysql/)
- [PHP-FPM](https://hub.docker.com/r/nanoninja/php-fpm/)
- [Composer](https://hub.docker.com/_/composer/)
- [PHPMyAdmin](https://hub.docker.com/r/phpmyadmin/phpmyadmin/)
- [Generate Certificate](https://hub.docker.com/r/jacoelho/generate-certificate/)

You should be careful when installing third party web servers such as MySQL or Nginx.

This project use the following ports :

| Server     | Port |
| ---------- | ---- |
| MySQL      | 3306 |
| PHPMyAdmin | 8080 |
| Nginx      | 80   |
| Nginx SSL  | 443  |

---

## Clone the project

To install [Git](http://git-scm.com/book/en/v2/Getting-Started-Installing-Git), download it and install following the instructions :

```sh
git clone https://github.com/katkamravikanth/apartment-management-system.git
```

Go to the project directory :

```sh
cd apartment-management-system
```

### Project tree

```sh
.
├── Makefile
├── README.md
├── data
│   └── db
│       ├── dumps
│       └── mysql
├── doc
├── docker-compose.yml
├── etc
│   ├── nginx
│   │   ├── default.conf
│   │   └── default.template.conf
│   ├── php
│   │   └── php.ini
│   └── ssl
└── web
    └── {application}
```

---

## Configure Nginx With SSL Certificates

You can change the host name by editing the `.env` file.

If you modify the host name, do not forget to add it to the `/etc/hosts` file.

1. Generate SSL certificates

   ```sh
   source .env && docker run --rm -v $(pwd)/etc/ssl:/certificates -e "SERVER=$NGINX_HOST" jacoelho/generate-certificate
   ```

2. Configure Nginx

   Do not modify the `etc/nginx/default.conf` file, it is overwritten by `etc/nginx/default.template.conf`

   Edit nginx file `etc/nginx/default.template.conf` and uncomment the SSL server section :

   ```sh
   # server {
   #     server_name ${NGINX_HOST};
   #
   #     listen 443 ssl;
   #     fastcgi_param HTTPS on;
   #     ...
   # }
   ```

---

## Configure Xdebug

If you use another IDE than [PHPStorm](https://www.jetbrains.com/phpstorm/) or [Netbeans](https://netbeans.org/), go to the [remote debugging](https://xdebug.org/docs/remote) section of Xdebug documentation.

For a better integration of Docker to PHPStorm, use the [documentation](https://github.com/nanoninja/docker-nginx-php-mysql/blob/master/doc/phpstorm-macosx.md).

1. Get your own local IP address :

   ```sh
   sudo ifconfig
   ```

2. Edit php file `etc/php/php.ini` and comment or uncomment the configuration as needed.

3. Set the `remote_host` parameter with your IP :

   ```sh
   xdebug.remote_host=192.168.0.1 # your IP
   ```

---

## Run the application

1. Copying the composer configuration file :

   ```sh
   cp web/composer.json.dist web/composer.json
   ```

2. Start the application :

   ```sh
   docker-compose up -d
   ```

   **Please wait this might take a several minutes...**

   ```sh
   docker-compose logs -f # Follow log output
   ```

3. Open your favorite browser :

   - [http://localhost:80](http://localhost:80/)
   - [https://localhost:443](https://localhost:443/) ([HTTPS](#configure-nginx-with-ssl-certificates) not configured by default)
   - [http://localhost:8080](http://localhost:8080/) PHPMyAdmin (username: dev, password: dev)

4. Stop and clear services

   ```sh
   docker-compose down -v
   ```

---

## Use Makefile

When developing, you can use [Makefile](<https://en.wikipedia.org/wiki/Make_(software)>) for doing the following operations :

| Name          | Description                                  |
| ------------- | -------------------------------------------- |
| apidoc        | Generate documentation of API                |
| clean         | Clean directories for reset                  |
| code-sniff    | Check the API with PHP Code Sniffer (`PSR2`) |
| composer-up   | Update PHP dependencies with composer        |
| docker-start  | Create and start containers                  |
| docker-stop   | Stop and clear all services                  |
| gen-certs     | Generate SSL certificates for `nginx`        |
| logs          | Follow log output                            |
| mysql-dump    | Create backup of all databases               |
| mysql-restore | Restore backup of all databases              |
| phpmd         | Analyse the API with PHP Mess Detector       |
| test          | Test application with phpunit                |

### Examples

Start the application :

```sh
make docker-start
```

Show help :

```sh
make help
```

---

## Use Docker commands

### Installing package with composer

```sh
docker run --rm -v $(pwd)/web:/app composer require symfony/yaml
```

### Updating PHP dependencies with composer

```sh
docker run --rm -v $(pwd)/web:/app composer update
```

### Generating PHP API documentation

```sh
docker run --rm -v $(pwd):/data phpdoc/phpdoc -i=vendor/ -d /data/web/src -t /data/web/doc
```

### Testing PHP application with PHPUnit

```sh
docker-compose exec -T php ./app/vendor/bin/phpunit --colors=always --configuration ./app
```

### Fixing standard code with [PSR2](http://www.php-fig.org/psr/psr-2/)

```sh
docker-compose exec -T php ./app/vendor/bin/phpcbf -v --standard=PSR2 ./app/src
```

### Checking the standard code with [PSR2](http://www.php-fig.org/psr/psr-2/)

```sh
docker-compose exec -T php ./app/vendor/bin/phpcs -v --standard=PSR2 ./app/src
```

### Analyzing source code with [PHP Mess Detector](https://phpmd.org/)

```sh
docker-compose exec -T php ./app/vendor/bin/phpmd ./app/src text cleancode,codesize,controversial,design,naming,unusedcode
```

### Checking installed PHP extensions

```sh
docker-compose exec php php -m
```

### Handling database

#### MySQL shell access

```sh
docker exec -it mysql bash
```

and

```sh
mysql -u"$MYSQL_ROOT_USER" -p"$MYSQL_ROOT_PASSWORD"
```

#### Creating a backup of all databases

```sh
mkdir -p data/db/dumps
```

```sh
source .env && docker exec $(docker-compose ps -q mysqldb) mysqldump --all-databases -u"$MYSQL_ROOT_USER" -p"$MYSQL_ROOT_PASSWORD" > "data/db/dumps/db.sql"
```

#### Restoring a backup of all databases

```sh
source .env && docker exec -i $(docker-compose ps -q mysqldb) mysql -u"$MYSQL_ROOT_USER" -p"$MYSQL_ROOT_PASSWORD" < "data/db/dumps/db.sql"
```

#### Creating a backup of single database

**`Notice:`** Replace "YOUR_DB_NAME" by your custom name.

```sh
source .env && docker exec $(docker-compose ps -q mysqldb) mysqldump -u"$MYSQL_ROOT_USER" -p"$MYSQL_ROOT_PASSWORD" --databases YOUR_DB_NAME > "data/db/dumps/YOUR_DB_NAME_dump.sql"
```

#### Restoring a backup of single database

```sh
source .env && docker exec -i $(docker-compose ps -q mysqldb) mysql -u"$MYSQL_ROOT_USER" -p"$MYSQL_ROOT_PASSWORD" < "data/db/dumps/YOUR_DB_NAME_dump.sql"
```

#### Connecting MySQL from [PDO](http://php.net/manual/en/book.pdo.php)

```php
<?php
    try {
        $dsn = 'mysql:host=mysql;dbname=test;charset=utf8;port=3306';
        $pdo = new PDO($dsn, 'dev', 'dev');
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
?>
```

## Installation Instructions

1. Run this command in terminal `docker exec -it php bash`
2. Copy `.env.dist` and rename it to `.env`
   - Add your own 32 digit alphanumerical string to `APP_SECRET` (Ex: **76a1f96fd36e73aae18779de9903033f**)
   - Uncomment and update `DATABASE_URL="mysql://username:password@127.0.0.1:3306/database?serverVersion=mariadb-10.4.8&charset=utf8mb4"` value with proper database credentials
   - Change **username** with your database username, **password** with your databse password and **database** with your database name in above line
3. Install dependencies:
   - `composer install` or `composer update`
4. Set up the database:
   - Set up Dev environment
     - `symfony console doctrine:migrations:migrate` (This command will create tables and its schema)
     - `symfony console doctrine:fixtures:load` (This command will add dummy data to begain with in dev environment)
5. To access API documentation
   - `http://127.0.0.1/api/doc`
6. To run test cases
   - Set up Test environment
     - `symfony console --env=test doctrine:database:create` (This command will create database for test environment)
     - `symfony console --env=test doctrine:migrations:migrate` (This command will create tables and its schema for test environment)
     - `symfony console --env=test doctrine:fixtures:load` (This command will add dummy data to run unit test in test environment)
   - Command to execute test cases
     - `php vendor/bin/phpunit`
