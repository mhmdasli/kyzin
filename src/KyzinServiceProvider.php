<?php

namespace MhmdAsli\Kyzin;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

class KyzinServiceProvider extends ServiceProvider
{
    protected $files;
  //  protected $defer = true;
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {


        if (is_dir(app_path().'/Modules/')) {
            $modules = config("modules.enable") ?: array_map('class_basename', $this->files->directories(app_path().'/Modules/'));
            foreach ($modules as $module) {
                // Allow routes to be cached
                if (!$this->app->routesAreCached()) {
                    $route_files = [
                        app_path() . '/Modules/' . $module . '/routes.php',
                        app_path() . '/Modules/' . $module . '/routes/web.php',
                        app_path() . '/Modules/' . $module . '/routes/api.php',
                    ];
                    foreach ($route_files as $route_file) {
                        if ($this->files->exists($route_file)) {
                            include $route_file;
                        }
                    }
                }
                $helper = app_path() . '/Modules/' . $module . '/helper.php';
                $providers = app_path() . '/Modules/' . $module . '/Providers';
                $views = app_path() . '/Modules/' . $module . '/Views';
                $trans = app_path() . '/Modules/' . $module . '/Translations';

                if ($this->files->exists($helper)) {
                    include_once $helper;
                }
                if ($this->files->isDirectory($providers)) {
                    $this->app->register('App\Modules\\' . $module .'\Providers\Provider');
                }
                if ($this->files->isDirectory($views)) {
                    $this->loadViewsFrom($views, $module);
                }
                if ($this->files->isDirectory($trans)) {
                    $this->loadTranslationsFrom($trans, $module);
                }
            }
        }
    }
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */


    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->files = new Filesystem;
        $this->registerMakeCommand();
    }

    /**
     * Register the "kyzin:core" console command.
     *
     * @return Console\ModuleMakeCommand
     */
    protected function registerMakeCommand()
    {
        $this->commands('modules.make');

        $bind_method = method_exists($this->app, 'bindShared') ? 'bindShared' : 'singleton';

        $this->app->{$bind_method}('modules.make', function ($app) {
            return new Console\ModuleMakeCommand($this->files);
        });
    }
}
