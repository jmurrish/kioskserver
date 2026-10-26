FROM php:7.4.0-fpm-alpine

ARG UID
ARG GID
ENV UID=${UID}
ENV GID=${GID}


RUN addgroup -g ${GID} --system laravel
RUN adduser -G laravel --system -D -s /bin/sh -u ${UID} laravel

RUN sed -i "s/user = www-data/user = laravel/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = laravel/g" /usr/local/etc/php-fpm.d/www.conf

 


ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
# RUN install-php-extensions pdo pdo_mysql
RUN install-php-extensions sqlite3 pdo pdo_sqlite pdo_mysql

USER laravel

WORKDIR /var/www/html


EXPOSE 9000

