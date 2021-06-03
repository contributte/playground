![](https://heatbadger.now.sh/github/readme/contributte/api-router/)

<p align=center>
Website 🚀 <a href="https://contributte.org">contributte.org</a> | Contact 👨🏻‍💻 <a href="https://f3l1x.io">f3l1x.io</a> | Twitter 🐦 <a href="https://twitter.com/contributte">@contributte</a>
</p>

This is example of `contributte/api-router` and `contributte/api-docu` usage for Nette Framework.

This repository is meant as a starter project for [contributte/api-router](https://github.com/contributte/api-router).

## Installation

```bash
composer install
```

## Usage

- Using `contributte/api-docu` for generating API docs
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

## Documentation

For details on how to use `contributte/api-router` and `contributte/api-docu` packages, check out our documentations:
- [contributte/api-docu](https://contributte.org/packages/contributte/api-docu.html)
- [contributte/api-router](https://contributte.org/packages/contributte/api-router.html)

## Development

See [how to contribute](https://contributte.org/contributing.html) to this package.

This package is currently maintaining by these authors.

<a href="https://github.com/f3l1x">
  <img width="80" height="80" src="https://avatars2.githubusercontent.com/u/538058?v=3&s=80">
</a>

<a href="https://github.com/petrparolek">
  <img width="80" height="80" src="https://avatars2.githubusercontent.com/u/6066243?v=3&s=80">
</a>

-----

Consider to [support](https://contributte.org/partners.html) **contributte** development team.
Also thank you for using this package.
