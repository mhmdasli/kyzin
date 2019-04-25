# Kyzin Core

This package gives you the ability to use Laravel 5 with module system.
You can simply drop or generate modules with their own commands, components, controllers, models, providers, views, helpers, translations and a routes file into the `app/Modules` folder and go on working with them.

## Documentation

* [Installation](#installation)
* [Getting started](#getting-started)
* [Usage](#usage)


<a name="installation"></a>
## Installation

The best way to install this package is through your terminal via Composer.

Run the following command from your projects root
```
composer require mhmdasli/kyzin
```
Once this operation is complete, simply add the service provider to your project's `config/app.php` and you're done.

#### Service Provider
```
Masli\Kyzin\KyzinServiceProvider::class,
```

<a name="getting-started"></a>
## Getting started

The built in Artisan command `php artisan kyzin:core name [--no-migration] [--no-translation]` generates a ready to use module in the `app/Modules` folder and a migration if necessary.

This is how the generated module would look like:
```
laravel-project/
    app/
    └── Modules/
        └── FooBar/
            ├── Commands/
            │   └── FooBarCommand.php
            ├── Components/
            │   └── FooBarComponent.php
            ├── Controllers/
            │   └── FooBarController.php
            ├── Models/
            │   └── FooBar.php
            ├── Providers/
            │   └── Provider.php
            ├── Views/
            │   └── index.blade.php
            ├── Translations/
            │   └── en/
            │       └── example.php
            ├── routes
            │   ├── api.php
            │   └── web.php
            └── helper.php
                
```

<a name="usage"></a>
## Usage

The generated `RESTful Resource Controller` and the corresponding `routes.php` make it easy to dive in. In my example you would see the output from the `Modules/FooBar/Views/index.blade.php` when you open `laravel-project:8000/foo-bar` in your browser.


#### Disable modules
In case you want to disable one ore more modules, you can add a `modules.php` into your projects `app/config` folder. This file should return an array with the module names that should be **loaded**.
F.a:
```
return [
    'enable' => array(
        "customer",
        "contract",
        "reporting",
    ),
];
```
In this case Kyzin would only load this three modules `customer` `contract` `reporting`. Every other module in the `app/Modules` folder would not be loaded.

Kyzin will load all modules if there is no modules.php file in the config folder.

#### Use a single `routes.php` file

Instead of using a single routes file there is a routes folder with the route files `web.php` and `api.php`. No panic, the old fashioned routes file will be loaded anyways. So if you like it that way you can stick with the single routes file in the module-root folder.

#### Load additional classes

In some cases there is a need to load different additional classes into a module. Since Laravel loads the app using the PSR-4 autoloading standard, you can just add folders and files almost without limitations. The only thing you should keep in mind is to add the correct namespace.

F.a. If you want to add the `App/Modules/FooBar/Services/FancyService.php` to your module, you can absolutely do so. The file could then look like this:
```
<?php 
namespace App\Modules\FooBar\Services;

class FancyService 
{
    public static function doFancyStuff() {
        return 'some output';
    } 
}

```


you have to follow the `upper camel case` name convention for the module folder. If you had a `Modules/foo` folder you have to rename it to `Modules/Foo`. 

Also there are changes in the `app/config/modules.php` file. Now you have to return an array with the key `enable` instead of `list`.

## License

Kyzin is licensed under the terms of the [MIT License](http://opensource.org/licenses/MIT)
(See LICENSE file for details).

---
