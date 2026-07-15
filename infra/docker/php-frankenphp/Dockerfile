FROM dunglas/frankenphp:1-php8.4 AS base

WORKDIR /workspace

# timezone / locale / composer / FrankenPHP HTTP-only in dev
ENV TZ=UTC \
  LANG=en_US.UTF-8 \
  LANGUAGE=en_US:en \
  LC_ALL=en_US.UTF-8 \
  COMPOSER_HOME=/composer \
  SERVER_NAME=:80

COPY --from=composer:2.10 /usr/bin/composer /usr/bin/composer

# hadolint ignore=DL3008
RUN <<EOF
  apt-get update
  apt-get -y install --no-install-recommends \
    locales \
    git \
    unzip \
    default-mysql-client \
    gosu
  locale-gen en_US.UTF-8
  localedef -f UTF-8 -i en_US en_US.UTF-8
  install-php-extensions \
    intl \
    pdo_mysql \
    zip \
    bcmath \
    opcache
  mkdir /composer
  apt-get clean
  rm -rf /var/lib/apt/lists/*
EOF

COPY --chmod=755 ./infra/docker/php-frankenphp/entrypoint.sh /usr/local/bin/entrypoint.sh

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["frankenphp", "run", "--config", "/etc/frankenphp/Caddyfile"]

FROM base AS development

COPY ./infra/docker/php/php.development.ini /usr/local/etc/php/php.ini

FROM development AS development-xdebug

RUN install-php-extensions xdebug

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
