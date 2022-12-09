FROM trafex/alpine-nginx-php7:1.10.0

ARG PHP_TIMEZONE_ARG="UTC"
ARG PHP_MEMORY_LIMIT_ARG="512M"
ARG PHP_POST_MAX_SIZE_ARG="32M"
ARG PHP_UPLOAD_MAX_ARG="32M"
ARG WP_DEBUG_LOG_ARG="/var/www/log/wordpress/debug.log"

ENV PHP_TIMEZONE=${PHP_TIMEZONE_ARG}
ENV PHP_MEMORY_LIMIT=${PHP_MEMORY_LIMIT_ARG}
ENV PHP_POST_MAX_SIZE=${PHP_POST_MAX_SIZE_ARG}
ENV PHP_UPLOAD_MAX=${PHP_UPLOAD_MAX_ARG}
ENV WP_DEBUG_LOG=${WP_DEBUG_LOG_ARG}

# Switch to use a root user from here on
USER root

# Customize nginx config
COPY dev-docker/config/nginx/nginx.conf /etc/nginx/nginx.conf

# Custom .ini
COPY dev-docker/config/php/custom.ini /etc/php7/conf.d/custom.ini

# Customize php-fpm pool config
COPY dev-docker/config/php/fpm/www.conf /etc/php7/php-fpm.d/www.conf

# Configure supervisord
COPY dev-docker/config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN adduser -D -H -G nobody devuser

# WP-CLI
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
RUN chmod +x wp-cli.phar
RUN mv wp-cli.phar /usr/local/bin/wp

# Install packages
RUN apk --no-cache add php7-redis php7-apcu php7-imagick php7-memcached php7-xdebug \
		php7-tokenizer php7-xmlwriter \
	curl wget openssl-dev

COPY ./dev-docker/wordpress/ /var/www/html/

RUN mkdir -p /var/www/html/wp-content/mu-plugins >/dev/null 2>&1
RUN mkdir -p /var/www/html/wp-content/cache >/dev/null 2>&1
RUN mkdir -p /var/www/html/wp-content/uploads >/dev/null 2>&1
RUN mkdir -p /var/www/html/wp-content/upgrade >/dev/null 2>&1
RUN chmod -R 777 /var/www/html/wp-content/uploads /var/www/html/wp-content/cache /var/www/html/wp-content/upgrade/

COPY ./dev-docker/config/wordpress/wp-config.php /var/www/html/wp-config.php

######## Update here for each particular project

# For using normal plugin as a MU Plugin
COPY ./dev-miscs/bedrock-autoloader.php /var/www/html/wp-content/mu-plugins/bedrock-autoloader.php

# Current project as a MU Plugin
RUN mkdir -p /var/www/html/wp-content/mu-plugins/enpii-base >/dev/null 2>&1
COPY ./ /var/www/html/wp-content/mu-plugins/enpii-base

# WP-CLI
COPY ./dev-miscs/wp-cli.yml /var/www/html/wp-cli.yml

# Switch to use a non-root user from here on
RUN chown -R devuser.nobody /var/www/html
USER nobody
