# docker-laravel 🐳

<p align="center">
    <img src="https://user-images.githubusercontent.com/35098175/145682384-0f531ede-96e0-44c3-a35e-32494bd9af42.png" alt="docker-laravel">
</p>
<p align="center">
    <img src="https://github.com/ucan-lab/docker-laravel/actions/workflows/laravel-create-project.yaml/badge.svg" alt="Test laravel-create-project.yml">
    <img src="https://github.com/ucan-lab/docker-laravel/actions/workflows/laravel-git-clone.yaml/badge.svg" alt="Test laravel-git-clone.yml">
    <img src="https://img.shields.io/github/license/ucan-lab/docker-laravel" alt="License">
</p>

## Introduction

Build a simple laravel development environment with Docker Compose. Support with Windows(WSL2), macOS(Intel and Apple Silicon) and Linux.

## Requirements

- **Docker Engine v23.0+ (BuildKit enabled by default) or the latest Docker Desktop**

The Dockerfile uses [here-documents (`RUN <<EOF`)](https://docs.docker.com/reference/dockerfile/#here-documents), which require [BuildKit](https://docs.docker.com/build/buildkit/). When BuildKit is disabled (e.g. an old Docker version or the legacy builder), the `RUN` instructions are silently skipped, so required packages such as `git` are never installed. The build still succeeds, but `composer install` later fails with `git was not found in your PATH`.

BuildKit is enabled by default on Docker Engine v23.0+ and Docker Desktop. If you must use an older Docker, enable it explicitly before building:

```bash
export DOCKER_BUILDKIT=1
export COMPOSE_DOCKER_CLI_BUILD=1
```

## Usage

### Create an initial Laravel project

1. Click [Use this template](https://github.com/ucan-lab/docker-laravel/generate)
2. Git clone & change directory
3. Execute the following command

```bash
$ task create-project

# or...

$ make create-project

# or... Linux environment

$ echo "UID=$(id -u)" >> .env
$ echo "GID=$(id -g)" >> .env
$ echo "USERNAME=$(whoami)" >> .env

$ mkdir -p src
$ docker compose build
$ docker compose --file compose.yaml --file compose-for-linux.yaml up --detach
$ docker compose exec app composer create-project --prefer-dist laravel/laravel .
$ docker compose exec app cp .env.example .env
$ docker compose exec app sed  -i 's/DB_CONNECTION=.*/DB_CONNECTION=mysql/' .env
$ docker compose exec app php artisan key:generate
$ docker compose exec app php artisan storage:link
$ docker compose exec app chmod -R 777 storage bootstrap/cache
$ docker compose exec app php artisan migrate
```

http://localhost

### Create an existing Laravel project

1. Git clone & change directory
2. Execute the following command

```bash
$ task install

# or...

$ make install

# or... Linux environment

$ echo "UID=$(id -u)" >> .env
$ echo "GID=$(id -g)" >> .env
$ echo "USERNAME=$(whoami)" >> .env

$ docker compose build
$ docker compose --file compose.yaml --file compose-for-linux.yaml up --detach
$ docker compose exec app composer install
$ docker compose exec app cp .env.example .env
$ docker compose exec app sed  -i 's/DB_CONNECTION=.*/DB_CONNECTION=mysql/' .env
$ docker compose exec app php artisan key:generate
$ docker compose exec app php artisan storage:link
$ docker compose exec app chmod -R 777 storage bootstrap/cache
```

http://localhost

## FrankenPHP (opt-in alternative stack)

[FrankenPHP](https://frankenphp.dev/) is available as an opt-in alternative to the default `nginx` + `php-fpm` stack. The default stack is **unchanged**; FrankenPHP is activated only when you explicitly pass the overlay file.

Key differences from the default stack:

- A single `app` container replaces both `app` and `web` (FrankenPHP serves HTTP itself on port 80).
- Runs in classic mode — file changes in `./src` are reflected immediately without rebuilding.
- An `xdebug` build target (`development-xdebug`) is available via `APP_BUILD_TARGET`.
- Run only one stack at a time — both bind port 80 and share the same Compose project. The `*-frankenphp` targets stop the default `web` container for you; if you start the overlay manually after the default stack, run `docker compose down` first.

### Use FrankenPHP with an existing Laravel project

```bash
$ task install-frankenphp

# or...

$ make install-frankenphp

# or... manually

$ docker compose -f compose.yaml -f compose.frankenphp.yaml build
$ docker compose -f compose.yaml -f compose.frankenphp.yaml rm --stop --force web
$ docker compose -f compose.yaml -f compose.frankenphp.yaml up --detach --remove-orphans
$ docker compose -f compose.yaml -f compose.frankenphp.yaml exec app composer install
$ docker compose -f compose.yaml -f compose.frankenphp.yaml exec app cp .env.example .env
$ docker compose -f compose.yaml -f compose.frankenphp.yaml exec app sed -i 's/DB_CONNECTION=.*/DB_CONNECTION=mysql/' .env
$ docker compose -f compose.yaml -f compose.frankenphp.yaml exec app php artisan key:generate
$ docker compose -f compose.yaml -f compose.frankenphp.yaml exec app php artisan storage:link
$ docker compose -f compose.yaml -f compose.frankenphp.yaml exec app chmod -R 777 storage bootstrap/cache
$ docker compose -f compose.yaml -f compose.frankenphp.yaml exec app php artisan migrate --force
```

On Linux, set your host UID/GID first so files generated in `./src` are owned by you. Run `task for-linux-env` (or append `UID=$(id -u)`, `GID=$(id -g)`, `USERNAME=$(whoami)` to `.env`) before the commands above; the FrankenPHP entrypoint reads these and falls back to `1000:1000` when they are unset.

http://localhost

## Tips

- Read this [Taskfile](https://github.com/ucan-lab/docker-laravel/blob/main/Taskfile.yml).
- Read this [Makefile](https://github.com/ucan-lab/docker-laravel/blob/main/Makefile).
- Read this [Wiki](https://github.com/ucan-lab/docker-laravel/wiki).

## Container structures

```bash
├── app
├── web
└── db
```

### app container

- Base image
  - [php](https://hub.docker.com/_/php):8.4-fpm-bullseye
  - [composer](https://hub.docker.com/_/composer):2.10
  - (FrankenPHP overlay) [dunglas/frankenphp](https://hub.docker.com/r/dunglas/frankenphp):1-php8.4

### web container

- Base image
  - [nginx](https://hub.docker.com/_/nginx):1.31

### db container

- Base image
  - [mysql](https://hub.docker.com/_/mysql):9.7

### mailpit container

- Base image
  - [axllent/mailpit](https://hub.docker.com/r/axllent/mailpit)
