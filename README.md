# Laravel Cutlet migrate
### Installation

```

composer require va/cutlet-migrate

```

#### Publish Config and Views

```

php artisan vendor:publish --tag=cutlet-migrate

```

#### Usage
You can run this command for use:
```
php artisan migrate:update
php artisan migrate:update --migrate
php artisan migrate:update --migrate --seed
php artisan migrate:update --migrate --seed --status
```
and show the help with this command:
```
php artisan --help migrate:update
or
php artisan migrate:update -h
```
and you can customize the mysql migrations directories:
```
return [
    /*
     * It's from 'database/migrations/' path..
     */
    'functions_path' => 'mysql/functions',
    'procedures_path' => 'mysql/procedures',
    'triggers_path' => 'mysql/triggers',
    'views_path' => 'mysql/views',
];
```

#### Requirements:

- PHP v7.0 or above
- Laravel v5.8 or above
