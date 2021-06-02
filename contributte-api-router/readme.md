# ApiRouter

This repository is meant as a starter project for [contributte/api-router](https://github.com/contributte/api-router).

## Installation

```bash
composer install
```

## Usage

- Using `contributte/api-router` for routing
- Implementing `IPresenter` in endpoints (`App\Controllers\LoginController`) instead of extending `UI\Presenter`
- Extending `ApiResponse` from Nette `JsonResponse`, just to make it more simple to add more custom headers and so on
- `LoginController` and `ErrorController` is using `ApiResponseFormatter` for formatting succes message, payload data or and exception

- Run:

```bash
docker-compose up -d
```

```bash
# return JSON
curl 'http://contributte-api-router.localhost:8080/api/login'  -H 'Content-Type: application/x-www-form-urlencoded' --data-raw run

# generating API documentation for the action
curl 'http://contributte-api-router.localhost:8080/api/login?__apiDocuGenerate'  -H 'Content-Type: application/x-www-form-urlencoded' --data-raw run
```

or visit page http://contributte-api-router.localhost:8080/
