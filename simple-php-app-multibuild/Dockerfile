#--------------- Build stage ---------------
FROM php:8.4-fpm-alpine AS source

WORKDIR /var/www/html

COPY files/src/index.php .

#--------------- Runtime -------------------
FROM php:8.4-fpm-alpine AS php-runtime

# Create separate user & group; we do not use root
RUN addgroup -S app && adduser -S -G app app
WORKDIR /var/www/html

COPY --from=source --chown=app:app \
    /var/www/html \
    /var/www/html

COPY files/config/php-fpm.conf \
    /usr/local/etc/php-fpm.d/zz-app.conf

USER app

EXPOSE 9000

CMD ["php-fpm", "-F"]

#------------- Nginx -----------------------
FROM nginx:stable-alpine-slim AS nginx

COPY files/config/nginx.conf \
    /etc/nginx/conf.d/default.conf

COPY --from=source \
    /var/www/html \
    /var/www/html

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]

