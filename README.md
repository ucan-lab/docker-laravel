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

## Usage

### Create an initial Laravel project

1. Click [Use this template](https://github.com/ucan-lab/docker-laravel/generate)
2. Git clone & change directory
3. Execute the following command

```bash
$ task for-linux-env # Linux environment only
$ task create-project

# or...

$ make for-linux-env # Linux environment only
$ make create-project

# or...

$ echo "UID=$(id -u)" >> .env # Linux environment only
$ echo "GID=$(id -g)" >> .env # Linux environment only

$ mkdir -p src
$ docker compose build
$ docker compose up -d
$ docker compose exec app composer create-project --prefer-dist laravel/laravel .
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
$ task for-linux-env # Linux environment only
$ task install

# or...

$ make for-linux-env # Linux environment only
$ make install

# or...

$ echo "UID=$(id -u)" >> .env # Linux environment only
$ echo "GID=$(id -g)" >> .env # Linux environment only

$ docker compose build
$ docker compose up -d
$ docker compose exec app composer install
$ docker compose exec app cp .env.example .env
$ docker compose exec app php artisan key:generate
$ docker compose exec app php artisan storage:link
$ docker compose exec app chmod -R 777 storage bootstrap/cache
```

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
  - [php](https://hub.docker.com/_/php):8.3-fpm-bullseye
  - [composer](https://hub.docker.com/_/composer):2.7

### web container

- Base image
  - [nginx](https://hub.docker.com/_/nginx):1.26

### db container

- Base image
  - [mysql](https://hub.docker.com/_/mysql):8.4

### mailpit container

- Base image
  - [axllent/mailpit](https://hub.docker.com/r/axllent/mailpit)
