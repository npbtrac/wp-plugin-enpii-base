FROM serversideup/php:8.0-fpm-nginx

USER root

RUN apt-get update \
    && apt-get -y --no-install-recommends install \
    # Ghostscript is required for rendering PDF previews
    ghostscript \
    php8.0-imagick \
    php8.0-apcu \
    php8.0-memcache \
    curl

# ENV DEBIAN_FRONTEND=noninteractive
# ENV TZ=Asia/Ho_Chi_Minh

# Disable force SSL https://github.com/serversideup/docker-php/tree/main#environment-variables
ENV SSL_MODE="off"

# RUN set -eux; \
# 	apt-get update
# RUN apt-get install curl

RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
RUN chmod +x wp-cli.phar
RUN mv wp-cli.phar /usr/local/bin/wp

# Use default for nginx virtual host
COPY ./dev-docker/config/nginx/default /etc/nginx/sites-available/ssl-off

# Overrides PHP configs
COPY ./dev-docker/config/php/cli/php-overrides.ini /etc/php/8.0/cli/conf.d/99-overrides.ini
COPY ./dev-docker/config/php/fpm/php-overrides.ini /etc/php/8.0/fpm/conf.d/99-overrides.ini
COPY ./dev-docker/config/php/fpm/pool.d/y-override-php-defaults.conf /etc/php/8.0/fpm/conf.d/pool.d/y-override-php-defaults.conf


RUN mkdir -p /var/www/html/public >/dev/null 2>&1
RUN mkdir -p /var/www/html/public/wp-content/mu-plugins >/dev/null 2>&1
RUN mkdir -p /var/www/html/public/wp-content/cache >/dev/null 2>&1
RUN mkdir -p /var/www/html/public/wp-content/uploads >/dev/null 2>&1
RUN mkdir -p /var/www/html/public/wp-content/upgrades >/dev/null 2>&1
RUN chown -R webuser:webgroup /var/www/html/public
RUN chmod -R 777 /var/www/html/public/wp-content/uploads /var/www/html/public/wp-content/cache

USER webuser

COPY ./dev-docker/wordpress/ /var/www/html/public
COPY ./dev-docker/config/wordpress/wp-config.php /var/www/html/wp-config.php

USER root

WORKDIR /var/www/html/public

## For specific project
USER webuser
COPY ./dev-miscs/bedrock-autoloader.php /var/www/html/public/wp-content/mu-plugins/bedrock-autoloader.php
USER root

# RUN wget https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64 && \
# 	chmod +x mhsendmail_linux_amd64 && \
# 	mv mhsendmail_linux_amd64 /usr/local/bin/mhsendmail


# RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# # persistent dependencies
# RUN set -eux; \
# 	apt-get update; \
# 	apt-get install -y --no-install-recommends \
# # Ghostscript is required for rendering PDF previews
# 		ghostscript \
# 	; \
# 	rm -rf /var/lib/apt/lists/*

# # install the PHP extensions we need (https://make.wordpress.org/hosting/handbook/handbook/server-environment/#php-extensions)
# RUN set -ex; \
# 	\
# 	savedAptMark="$(apt-mark showmanual)"; \
# 	\
# 	apt-get update; \
# 	apt-get install -y --no-install-recommends \
# 		libfreetype6-dev \
# 		libjpeg-dev \
# 		libmagickwand-dev \
# 		libpng-dev \
# 	; \
# 	\
# 	docker-php-ext-configure gd --with-freetype-dir=/usr --with-jpeg-dir=/usr --with-png-dir=/usr; \
# 	docker-php-ext-install -j "$(nproc)" \
# 		bcmath \
# 		exif \
# 		gd \
# 		mysqli \
# 		zip \
# 	; \
# 	pecl install imagick-3.4.4; \
# 	docker-php-ext-enable imagick; \
# 	pecl install redis; \
#     docker-php-ext-enable redis; \
#     pecl install apcu; \
#     docker-php-ext-enable apcu; \
# 	\
# # reset apt-mark's "manual" list so that "purge --auto-remove" will remove all build dependencies
# 	apt-mark auto '.*' > /dev/null; \
# 	apt-mark manual $savedAptMark; \
# 	ldd "$(php -r 'echo ini_get("extension_dir");')"/*.so \
# 		| awk '/=>/ { print $3 }' \
# 		| sort -u \
# 		| xargs -r dpkg-query -S \
# 		| cut -d: -f1 \
# 		| sort -u \
# 		| xargs -rt apt-mark manual; \
# 	\
# 	apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false; \
# 	rm -rf /var/lib/apt/lists/*

# # set recommended PHP.ini settings
# # see https://secure.php.net/manual/en/opcache.installation.php
# RUN set -eux; \
# 	docker-php-ext-enable opcache; \
# 	{ \
# 		echo 'opcache.memory_consumption=128'; \
# 		echo 'opcache.interned_strings_buffer=8'; \
# 		echo 'opcache.max_accelerated_files=4000'; \
# 		echo 'opcache.revalidate_freq=2'; \
# 		echo 'opcache.fast_shutdown=1'; \
# 	} > /usr/local/etc/php/conf.d/opcache-recommended.ini
# # https://wordpress.org/support/article/editing-wp-config-php/#configure-error-logging
# RUN { \
# # https://www.php.net/manual/en/errorfunc.constants.php
# # https://github.com/docker-library/wordpress/issues/420#issuecomment-517839670
# 		echo 'error_reporting = E_ERROR | E_WARNING | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_COMPILE_WARNING | E_RECOVERABLE_ERROR'; \
# 		echo 'display_errors = Off'; \
# 		echo 'display_startup_errors = Off'; \
# 		echo 'log_errors = On'; \
# 		echo 'error_log = /dev/stderr'; \
# 		echo 'log_errors_max_len = 1024'; \
# 		echo 'ignore_repeated_errors = On'; \
# 		echo 'ignore_repeated_source = Off'; \
# 		echo 'html_errors = Off'; \
# 	} > /usr/local/etc/php/conf.d/error-logging.ini

# ## Nginx
# RUN apt-get update -y
# RUN apt-get install -y nginx wget zip
# RUN rm /etc/nginx/sites-enabled/default
# COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf
# COPY ./docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf
# COPY ./docker/php/php-custom.ini /usr/local/etc/php/conf.d/zz-php-custom.ini
# RUN sed -i 's|access_log /var/log/nginx/access.log|access_log /proc/self/fd/2|g' /etc/nginx/nginx.conf
# RUN sed -i 's|error_log /var/log/nginx/error.log|error_log /proc/self/fd/2|g' /etc/nginx/nginx.conf

# COPY ./vendor/johnpbloch/wordpress-core /var/www/wordpress
# COPY ./vendor/wp-plugin/woocommerce /var/www/wordpress/wp-content/plugins/woocommerce
# COPY ./vendor/wp-plugin/woo-checkout-field-editor-pro /var/www/wordpress/wp-content/plugins/woo-checkout-field-editor-pro
# COPY ./vendor/wp-theme/storefront /var/www/wordpress/wp-content/themes/storefront
# COPY ./docker/wordpress/wp-config.php /var/www/wp-config.php

# WORKDIR /var/www/wordpress

# # Composer
# RUN cd /var/www/wordpress
# RUN wget https://getcomposer.org/download/2.0.4/composer.phar && \
#     mv composer.phar /usr/local/bin/composer && \
#     chmod +x /usr/local/bin/composer

# ## Cleanup
# RUN apt-get clean

# # Nginx
# COPY ./docker/nginx/start.sh /scripts/start.sh
# RUN chmod +x /scripts/start.sh
# CMD /scripts/start.sh
