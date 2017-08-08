# API - content negotiation

This little project demonstrates usage of `contributte/api` with `contributte/middlewares` + `contributte/psr7-http-message` 
and content negotiation, it means that converts output to JSON/XML and DEBUG format.

## Install

```sh
composer install
```

## Usage

```sh
php -S 0.0.0.0:8000 -t www www/index.php 
```

## Showcase

Navigates to:

- `http://localhost:8000/users/`
- `http://localhost:8000/users/users/1`
- `http://localhost:8000/users/meta`

Content negotiation:

- `http://localhost:8000/users/`
- `http://localhost:8000/users.json`
- `http://localhost:8000/users.debug`
