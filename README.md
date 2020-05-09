# docker-laravel

![License](https://img.shields.io/github/license/ucan-lab/docker-laravel?color=f05340)
![Stars](https://img.shields.io/github/stars/ucan-lab/docker-laravel?color=f05340)
![Issues](https://img.shields.io/github/issues/ucan-lab/docker-laravel?color=f05340)
![Forks](https://img.shields.io/github/forks/ucan-lab/docker-laravel?color=f05340)

## Introduction

Build laravel development environment with docker-compose.

## Usage

- [Build for Mac](https://github.com/ucan-lab/docker-laravel/wiki/Build-for-Mac)
- [Build for Windows](https://github.com/ucan-lab/docker-laravel/wiki/Build-for-Windows)

## Container structure

```bash
├── app
├── web
├── db
├── redis
└── mail
```

### app container

- Base image
  - php:7.4-fpm-buster
  - composer:latest

### web container

- Base image
  - nginx:1.17-alpine
  - node:14.2-alpine

### db container

- Base image
  - mysql:8.0

### redis container

- Base image
  - redis:6.0-alpine

### mail container

- Base image
  - mailhog/mailhog
