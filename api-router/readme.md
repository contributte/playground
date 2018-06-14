[![Latest Stable Version](https://poser.pugx.org/ublaboo/api-router-project/v/stable)](https://packagist.org/packages/ublaboo/api-router-project)
[![License](https://poser.pugx.org/ublaboo/api-router-project/license)](https://packagist.org/packages/ublaboo/api-router-project)
[![Total Downloads](https://poser.pugx.org/ublaboo/api-router-project/downloads)](https://packagist.org/packages/ublaboo/api-router-project)
[![Gitter](https://img.shields.io/gitter/room/nwjs/nw.js.svg)](https://gitter.im/ublaboo/help)

# ApiRouter Example Project

This repository is meant as a starter project for [ublaboo/api-router](https://github.com/ublaboo/api-router).

## Requirements

PHP 7.1 or higher.


## ublaboo/api-router-project usage

	composer create-project ublaboo/api-router-project


## Long Story Short

- Using `ublaboo/api-router` for routing
- Implementing `IPresenter` in endpoints (`App\Controllers\LoginController`) instead of extending `UI\Presenter`
- Extending `ApiResponse` from Nette `JsonResponse`, just to make it more simple to add more custom headers and so on
- `LoginController` and `ErrorController` is using `ApiResponseFormatter` for formatting succes message, payload data or and exception
