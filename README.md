# Laravel & Angular SPA 

> A Laravel 10 | Angular 15 SPA starter kit.
<p align="center">
<img src="https://i.imgur.com/NHFTsGt.png">
</p>

## Features

- Laravel 15
- Angular + Angular Material + RxJs
- Pages with dynamic import and custom layouts
- Login, register, email verification and password reset
- Authentication with Laravel sanctum
- Socialite integration
- Docker

## Installation 
### Laravel run with Docker 
-  http://localhost:8080/api
- `make init`


### Angular
- `cd frontend && ng serve`


## Socialite

This project comes with GitHub as an example for [Laravel Socialite](https://laravel.com/docs/5.8/socialite).

To enable the provider create a new GitHub application and use `https://example.com/api/oauth/github/callback` as the Authorization callback URL.

Edit `.env` and set `GITHUB_CLIENT_ID` and `GITHUB_CLIENT_SECRET` with the keys form your GitHub application.

For other providers you may need to set the appropriate keys in `config/services.php` and redirect url in `OAuthController.php`.

## Email Verification
Check mailhog message
http://localhost:8025/#


## Testing

```bash
# Run unit and feature tests
make test
```
