# API - content negotiation

This medium project demonstrates usage of [`contributte/api`](https://github.com/contributte/api) 
with [`contributte/middlewares`](https://github.com/contributte/middlewares) + [`contributte/psr7-http-message`](https://github.com/contributte/psr7-http-message)
and content negotiation, that means it could convert output to JSON/XML/DEBUG and any other format.

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
