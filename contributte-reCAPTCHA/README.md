# Google reCAPTCHA

This is example of Google reCAPTCHA for Nette Framework.

## Installation

```bash
composer install
```

Generate keys at [reCAPTCHA administration](https://www.google.com/recaptcha/admin#list)
And add them in `app/config/config.neon` in `recaptcha` section.

## See

- `app/Presenters/HomepagePresenter` for how is recaptcha form created.
- `app/Presenters/InvisiblePresenter` for how is invisible recaptcha form created.
- `app/Presenters/HiddenElementPresenter` for how to recaptcha form toggle.
