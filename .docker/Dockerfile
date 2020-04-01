FROM alpine:3.11

MAINTAINER Maxime Malgorn <maxime.malgorn@laposte.net>

# Install packages
RUN apk --no-cache add php7 php7-fpm php7-json php7-curl php7-openssl php7-mbstring \
    php7-xml php7-phar php7-intl php7-xmlreader php7-ctype \
    php7-tokenizer php7-fileinfo php7-xmlwriter php7-simplexml \
    nginx supervisor curl

# Install Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Configure Nginx, PHP-FPM and Supervisord
COPY .docker/nginx.conf /etc/nginx/nginx.conf
COPY .docker/php-fpm.conf /etc/php7/php-fpm.d/www.conf
COPY .docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
RUN rm /etc/nginx/conf.d/default.conf

# Setup document root
RUN mkdir -p /var/www/html
RUN chown -R nobody.nobody /var/www/html && \
  chown -R nobody.nobody /run && \
  chown -R nobody.nobody /var/lib/nginx && \
  chown -R nobody.nobody /var/log/nginx

# Create a new volume
VOLUME /var/www/html/storage

# Switch to a non-root user
USER nobody

# Add application
WORKDIR /var/www/html
COPY --chown=nobody . ./

# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-suggest --no-progress

# Expose the port and start services
EXPOSE 8080
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
