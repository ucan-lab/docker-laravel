# docker-laravel

## Introduction

Build Laravel's development environment using docker.

## Usage

- [Build for Mac](https://github.com/ucan-lab/docker-laravel/wiki/Build-for-Mac)
- [Build for Windows](https://github.com/ucan-lab/docker-laravel/wiki/Build-for-Windows)

## Container structure

- app
- web
- db
- redis
- mail

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
