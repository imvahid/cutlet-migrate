# Laravel Cutlet migrate
[![GitHub issues](https://img.shields.io/github/issues/va1hi9da9sh2ou0rz2ad1eh7/cutlet-migrate?style=flat-square)](https://github.com/va1hi9da9sh2ou0rz2ad1eh7/cutlet-migrate/issues)
[![GitHub stars](https://img.shields.io/github/stars/va1hi9da9sh2ou0rz2ad1eh7/cutlet-migrate?style=flat-square)](https://github.com/va1hi9da9sh2ou0rz2ad1eh7/cutlet-migrate/stargazers)
[![GitHub forks](https://img.shields.io/github/forks/va1hi9da9sh2ou0rz2ad1eh7/cutlet-migrate?style=flat-square)](https://github.com/va1hi9da9sh2ou0rz2ad1eh7/cutlet-migrate/network)
[![GitHub license](https://img.shields.io/github/license/va1hi9da9sh2ou0rz2ad1eh7/cutlet-migrate?style=flat-square)](https://github.com/va1hi9da9sh2ou0rz2ad1eh7/cutlet-migrate/blob/master/LICENSE)

### Installation

```
composer require va/cutlet-migrate
```

#### Publish Config

```
php artisan vendor:publish --tag=cutlet-migrate
```

#### Usage
You can run this command for use:
```
php artisan migrate:update
php artisan migrate:update --migrate|-m
php artisan migrate:update --migrate|-m --seed|-s
php artisan migrate:update --migrate|-m --seed|-s --status|-t
```
and show the help with this command:
```
php artisan --help migrate:update
or
php artisan migrate:update -h
```
and you can customize the mysql migrations directories:
```php
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
#### How to create functions, procedures, triggers and views in laravel:
```
Use this command once time in project after install cutlet-migrate:
php artisan migrate:update

## Create a function:
php artisan make:migration function_name --path=database/migrations/mysql/functions

## Create a procedure:
php artisan make:migration procedure_name --path=database/migrations/mysql/procedures

## Create a trigger:
php artisan make:migration trigger_name --path=database/migrations/mysql/triggers

## Create a view:
php artisan make:migration view_name --path=database/migrations/mysql/views
```

#### How to write functions, procedures, triggers and views in migrations:
```php
## Write a function:

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CutletFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::unprepared("
            DROP FUNCTION IF EXISTS function_name;
            CREATE FUNCTION function_name(
                param1 INT,
                param2 INT,
                ..
            )
            RETURNS datatype
            [NOT] DETERMINISTIC
            BEGIN
                -- statements
            END
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\DB::unprepared("
            DROP FUNCTION if EXISTS function_name;
        ");
    }
}
```
```php
## Write a procedure:

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CutletProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::unprepared("
            DROP PROCEDURE IF EXISTS procedure_name;
            CREATE PROCEDURE procedure_name(
                IN param1 INT,
                IN param2 INT,
                ..
            )
            BEGIN
                -- statements    
            END
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\DB::unprepared("
            DROP PROCEDURE IF EXISTS procedure_name;
        ");
    }
}
```
```php
## Write a trigger:

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CutletTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::unprepared("
            DROP TRIGGER IF EXISTS trigger_name;
            CREATE TRIGGER trigger_name
            {BEFORE | AFTER} {INSERT | UPDATE| DELETE }
            ON table_name FOR EACH ROW
                -- trigger_body;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\DB::unprepared("
            DROP TRIGGER IF EXISTS trigger_name;
        ");
    }
}
```
```php
## Write a view:

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CutletView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::unprepared("
            DROP VIEW IF EXISTS view_name;
            CREATE [OR REPLACE] VIEW [db_name.]view_name [(column_list)]
            AS
              -- select-statement;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\DB::unprepared("
            DROP VIEW IF EXISTS view_name;
        ");
    }
}
```

#### How to use functions, procedures, triggers and views in controllers or repositories:
```php
## Use functions:
$cutlet = DB::select('select cutletFunction(?,?) as cutletField', [$request->param1, $request->param2]);
// or ..

## Use procedures
$cutlets = DB::select('call cutletProcedure(?)', [$request->param1]);
or ..

## Use triggers:
// It's execute auto in mysql level

## Use views:
$cutlets = DB::table('cutletView');
```

#### Requirements:

- PHP v7.0 or above
- Laravel v5.8 or above
