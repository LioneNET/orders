FROM php:8.2.0-fpm

WORKDIR /var/www/laravel_docker
RUN apt update \
        && apt install -y \
            git \
            nano \
            g++ \
            libicu-dev \
            libpq-dev \
            libzip-dev \
            zip \
            zlib1g-dev \
            libldap2-dev -y \
	    libpng-dev \
            && rm -rf /var/lib/apt/lists/* \
        && docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ \     
        && docker-php-ext-install \
            intl \
            pcntl \
            zip \
            gd \
            opcache \
            pdo \
            pdo_pgsql \
            pgsql \
            mysqli \
            pdo_mysql \
            ldap \
        && docker-php-ext-enable \
            pdo_mysql \
            pcntl \
            zip \
            gd
            # ldap
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ADD . /var/www/laravel_docker
RUN chown -R www-data:www-data /var/www/laravel_docker
CMD ["php-fpm"]
