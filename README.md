# Laravel & Angular SPA 

> A Laravel 10 | Angular 15 SPA starter kit.
<p align="center">
<img src="https://raw.githubusercontent.com/bcode-devs/laravel-angular/main/documentation/sign-in.png">
</p>

<p align="center">
<img src="https://raw.githubusercontent.com/bcode-devs/laravel-angular/main/documentation/sign-up.png">
</p>


## Features

- Laravel 15
- Angular + Angular Material + RxJs
- Login, register, email verification and password reset
- Authentication with Laravel sanctum
- Socialite integration
- Docker compose
- Laravel horizon

> A Laravel 10 | Module structure
https://github.com/nWidart/laravel-modules
- Check api/Modules folder
- | Auth | Profile

## Installation 
```bash
### Laravel run with Docker 
-  http://localhost:8080/api
-  make init
```

### Angular
```bash
- cd frontend
- npm install
- ng serve
```

## Socialite

This project comes with GitHub as an example for [Laravel Socialite](https://laravel.com/docs/5.8/socialite).

To enable the provider create a new GitHub application and use `https://example.com/api/oauth/github/callback` as the Authorization callback URL.

Edit `.env` and set `GITHUB_CLIENT_ID` and `GITHUB_CLIENT_SECRET` with the keys form your GitHub application.

For other providers you may need to set the appropriate keys in `config/services.php` and redirect url in `OAuthController.php`.

## Email Verification
Check mailhog message
http://localhost:8025/#
<p align="center">
<img src="https://raw.githubusercontent.com/bcode-devs/laravel-angular/main/documentation/email.png">
</p>

## Laravel Horizon
http://localhost:8080/horizon
<p align="center">
<img src="https://raw.githubusercontent.com/bcode-devs/laravel-angular/main/documentation/horizon.png">
</p>


## Testing

```bash
# Run unit and feature tests
make test
```

### Laravel-Vue Version
https://github.com/cretueusebiu/laravel-vue-spa
