FROM serversideup/php:8.4-fpm-nginx
USER root
WORKDIR /var/www/html
COPY . .
RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache && chown -R www-data:www-data storage bootstrap/cache
USER www-data
ENV AUTORUN_LARAVEL_MIGRATION=false
