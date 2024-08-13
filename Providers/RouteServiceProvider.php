<?php

namespace Modules\CHEvents\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Modules\CHEvents\Http\Controllers\Frontend\IndexController;

/**
 * Register the routes required for your module here
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * The root namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $namespace = 'Modules\CHEvents\Http\Controllers';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     *
     * @param  Router $router
     * @return void
     */
    public function before(Router $router)
    {
        //
    }

    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function map(Router $router)
    {
        $this->registerWebRoutes();
        $this->registerAdminRoutes();
        $this->registerApiRoutes();
    }

    /**
     *
     */
    protected function registerWebRoutes(): void
    {
        $config = [
            'as'         => 'chevents.',
            'prefix'     => 'events',
            'namespace'  => $this->namespace.'\Frontend',
            'middleware' => ['web', 'auth'],
        ];

        Route::group($config, function() {
            Route::get('/', [IndexController::class, 'index'])->name('index');
            Route::get('/{event}', [IndexController::class, 'show'])->name('show');
            Route::post('/{event}/user', [IndexController::class, 'attach'])->name('attach');
            Route::delete('/{event}/user', [IndexController::class, 'detach'])->name('detach');
            Route::get('/{event}/flights/create', [IndexController::class, 'create_flight'])->name('flights.create');
            Route::post('/{event}/flights', [IndexController::class, 'store_flight'])->name('flights.store');
        });
    }

    protected function registerAdminRoutes(): void
    {
        $config = [
            'as'         => 'admin.chevents.',
            'prefix'     => 'admin/chevents',
            'namespace'  => $this->namespace.'\Admin',
            'middleware' => ['web', 'ability:admin,admin-access'],
        ];

        Route::group($config, function() {
            Route::get('/', 'AdminController@index')->name('index');
            Route::get('/create', 'AdminController@create')->name('create');
            Route::post('/', 'AdminController@store')->name('store');
            Route::get('/{event}', 'AdminController@show')->name('show');
            Route::get('/{event}/edit', 'AdminController@edit')->name('edit');
            Route::patch('/{event}', 'AdminController@update')->name('update');
            Route::delete('/{event}', 'AdminController@destroy')->name('destroy');
            Route::group(['prefix' => '{event}/pireps', 'as' => 'pireps.'], function () {
                Route::get('/', 'AdminController@show_pireps')->name('index');
                Route::patch('/', 'AdminController@attach_pirep')->name('attach');
                Route::delete('/', 'AdminController@detach_pirep')->name('detach');
            });
            Route::group(['prefix' => '{event}/users', 'as' => 'users.'], function () {
                Route::get('/', 'AdminController@show_users')->name('index');
                Route::patch('/', 'AdminController@attach_user')->name('attach');
                Route::delete('/', 'AdminController@detach_user')->name('detach');
            });
        });
    }

    /**
     * Register any API routes your module has. Remove this if you aren't using any
     */
    protected function registerApiRoutes(): void
    {
        $config = [
            'as'         => 'api.chevents.',
            'prefix'     => 'api/chevents',
            'namespace'  => $this->namespace.'\Api',
            'middleware' => ['api'],
        ];

        Route::group($config, function() {
            $this->loadRoutesFrom(__DIR__.'/../Http/Routes/api.php');
        });
    }
}
