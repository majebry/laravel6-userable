# Laravel Userable

This package transforms Laravel's `User` model to be an "abstract-like" model so that you can create as much separate userable (*user-type*) models as you wish with their auth controllers and a middleware by just running some command.

## Installation

Use composer dependency manager to install this package.

```bash
composer require majebry/laravel6-userable
```

## Usage

1. publish migrations:

```bash
php artisan vendor:publish --provider="Majebry\LaravelUserable\UserableServiceProvider" --tag="migrations"
```

2. Include Userable trait into your Laravel's User model

```php
class User extends Authenticatable
{
    use \Majebry\LaravelUserable\Traits\Userable;
    //...
}
```

3. Now, for example, if we want to generate a *user-type* called `Customer`, we run the following command

```bash
php artsian userable:make Customer
```

This command will generate a `Customer` model under `app` directory
and a `x_create_customers_table.php` under `database\migrations` directory
You can add the fields that you wish to that migration before running it

4. Add the following middleware to `app\Http\Kernel.php`

```php

```

you may wish to update the `$guard_name` attribute and reference a relationship to Laravel's `User` model
(especially if you want to use laravel-permission pacakge in this model) .... bla

```php
protected $guard_name = 'api';

public function user()
{
    return $this->morphOne('App\User', 'userable');
}
```
So, anytime you want to call user info for any userable model you can do `Model::find($id)->userable`

5. In app/Http/Kernal.php, register the following middlewares
```php
protected $routeMiddleware = [
    // ...
    'userable-auth' => \Majebry\LaravelUserable\Http\Middleware\UserTypeMiddleware::class,
];
```
Now for example, if you want to protect a route to be only accessible for `StoreAdmin`, you can chain the Route with `->middleware('userable-auth:store-admin')`

## Contributing
...

## Todo
- Probably make the generator command also generates custom authentication actions(routes and controllers), middleware and/or views with the generator command.
- Add tests
- Making the UserTypeMiddleware supports multiple user-types
- Hooking into on User/Userable `Delete` event?

## License
[MIT](https://choosealicense.com/licenses/mit/)