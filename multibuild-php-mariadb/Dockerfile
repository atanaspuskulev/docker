#--------------- Build -------------------
FROM php:8.4-fpm-alpine AS source

WORKDIR /var/www/html

COPY files/src/index.php .

#--------------- Runtime -----------------
FROM php:8.4-fpm-alpine AS php-runtime

RUN addgroup -S app \
    && adduser -S -G app app

RUN docker-php-ext-install pdo_mysql

WORKDIR /var/www/html

COPY --from=source --chown=app:app \
    /var/www/html \
    /var/www/html


COPY files/config/php-fpm.conf \
    /usr/local/etc/php-fpm.d/zz-app.conf

USER app

EXPOSE 9000

CMD ["php-fpm", "-F"]

# ---------------- Nginx -----------------
FROM nginx:stable-alpine-slim AS nginx

WORKDIR /etc/nginx/conf.d

COPY files/config/nginx.conf default.conf

COPY --from=source \
    /var/www/html \
    /var/www/html

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]

# -------------------------- MariaDB --------------------
FROM mariadb:latest AS mariadb

VOLUME ["/var/lib/mysql"]

EXPOSE 3306

