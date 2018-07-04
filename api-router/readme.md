# ApiRouter

This repository is meant as a starter project for [contributte/api-router](https://github.com/contributte/api-router).

## Installation

```
git pull git@github.com:contributte/playground.git
cd api-router
composer install
```

## Usage

- Using `ublaboo/api-router` for routing
- Implementing `IPresenter` in endpoints (`App\Controllers\LoginController`) instead of extending `UI\Presenter`
- Extending `ApiResponse` from Nette `JsonResponse`, just to make it more simple to add more custom headers and so on
- `LoginController` and `ErrorController` is using `ApiResponseFormatter` for formatting succes message, payload data or and exception
