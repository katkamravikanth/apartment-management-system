FROM php:8.2-fpm

RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip libsodium-dev libwebp-dev libjpeg62-turbo-dev libpng-dev libxpm-dev libfreetype6-dev \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && docker-php-ext-install sodium \
    && docker-php-ext-enable sodium \
    && apt-get install -y librabbitmq-dev libssh-dev \
    && docker-php-ext-install bcmath sockets \
    && pecl install amqp \
    && docker-php-ext-enable amqp \
    && docker-php-ext-configure gd \
    && docker-php-ext-install gd

RUN apt install -y nodejs npm

RUN apt purge -y --auto-remove
RUN npm install -g yarn

WORKDIR /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony
RUN git config --global user.email "katkamravikanth22@gmail.com" \ 
    && git config --global user.name "Ravikanth Katkam"
