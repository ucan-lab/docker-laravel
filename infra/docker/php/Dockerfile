FROM php:8.3-fpm-bullseye AS base

WORKDIR /workspace

# timezone environment
ENV TZ=UTC \
  # locale
  LANG=en_US.UTF-8 \
  LANGUAGE=en_US:en \
  LC_ALL=en_US.UTF-8 \
  # composer environment
  COMPOSER_HOME=/composer

COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# hadolint ignore=DL3008
RUN <<EOF
  apt-get update
  apt-get -y install --no-install-recommends \
    locales \
    git \
    unzip \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    default-mysql-client \
    gosu
  locale-gen en_US.UTF-8
  localedef -f UTF-8 -i en_US en_US.UTF-8
  docker-php-ext-install \
    intl \
    pdo_mysql \
    zip \
    bcmath
  mkdir /composer
  apt-get clean
  rm -rf /var/lib/apt/lists/*
EOF

COPY --chmod=755 ./infra/docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh

FROM base AS development

COPY ./infra/docker/php/php.development.ini /usr/local/etc/php/php.ini

FROM base AS development-xdebug

RUN <<EOF
  pecl install xdebug
  docker-php-ext-enable xdebug
EOF

COPY ./infra/docker/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

FROM base AS deploy

COPY ./infra/docker/php/php.deploy.ini /usr/local/etc/php/php.ini
COPY ./src /workspace

RUN <<EOF
  composer install --quiet --no-interaction --no-ansi --no-dev --no-scripts --no-progress --prefer-dist
  composer dump-autoload --optimize
  chmod -R 777 storage bootstrap/cache
  php artisan optimize:clear
  php artisan optimize
EOF
