# Building BASE image
FROM php:7.4-fpm-alpine as base

RUN  apk add --no-cache \
        zlib \
        libzip && \
     apk add --no-cache --virtual .build-deps \
        oniguruma-dev \
        libxml2-dev \
        zlib-dev \
        libzip-dev && \
     docker-php-ext-install \
        exif \
        dom \
        mbstring \
        bcmath \
        sockets \
        pdo_mysql \
        zip && \
     apk del .build-deps

RUN apk add --no-cache freetype libpng libjpeg-turbo freetype-dev libpng-dev libjpeg-turbo-dev && \
  docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
  NPROC=$(grep -c ^processor /proc/cpuinfo 2>/dev/null || 1) && \
  docker-php-ext-install -j$(nproc) gd && \
  apk del --no-cache freetype-dev libpng-dev libjpeg-turbo-dev

WORKDIR /home/wwwroot/course

CMD ["php-fpm"]

# Building PROD image
FROM base as prod

RUN echo "running PROD commands"

COPY ops/docker/app/run-prod.sh /
#COPY api/.env.local.php  .env.local.php

CMD ["/run-prod.sh"]

#COPY api/.env.local.php  .env.local.php

# Building DEV image
FROM base as dev
RUN echo "running DEV commands"

COPY ops/docker/app/run-dev.sh /
RUN apk add --no-cache \
        sudo \
        git \
        python2 \
        make \
        gcc \
        g++ \
        npm && \
    chmod +x /run-dev.sh && \
    echo "nobody ALL=(ALL) NOPASSWD:ALL" > /etc/sudoers

RUN wget --no-check-certificate https://phar.phpunit.de/phpunit-6.5.3.phar && \
    mv phpunit*.phar phpunit.phar && \
    chmod +x phpunit.phar && \
    mv phpunit.phar /usr/local/bin/phpunit

RUN curl -sSk https://getcomposer.org/installer | php -- && \
    mv composer.phar /usr/local/bin/composer && \
    chmod +x /usr/local/bin/composer

WORKDIR /home/wwwroot

CMD ["/run-dev.sh"]
