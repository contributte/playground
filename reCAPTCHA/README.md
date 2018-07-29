# Google reCAPTCHA

This is example of Google reCAPTCHA for Nette Framework.

## Installation

```
git pull git@github.com:contributte/playground.git
cd reCAPTCHA
composer install
```

Generate keys at [reCAPTCHA administration](https://www.google.com/recaptcha/admin#list)
And add them in `app/config/config.neon` in `recaptcha` section.

## See

- `app/PresentersHomepagePresenter` for how is recaptcha form created.
