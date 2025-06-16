<?php

namespace App\Providers;


use App\Models\User;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;
use Illuminate\Support\Str;
use Illuminate\Routing\Route;
use Dedoc\Scramble\Scramble;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;




class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */

     public function boot(): void
    {
        // Gunakan Tailwind untuk pagination
        Paginator::useTailwind();

        // Definisikan gate untuk admin
        Gate::define('admin', function (User $user) {
            return $user->is_admin === true;
        });

        // Konfigurasi Scramble (API documentation generator)
        Scramble::configure()
            ->routes(function (Route $route) {
                return Str::startsWith($route->getPrefix(), 'api');
            })
            ->withDocumentTransformers(function (OpenApi $openApi): void {
                $openApi->secure(
                    SecurityScheme::http('bearer')
                );
            });
    }
    // public function boot(): void
    // {
    //     Paginator::useTailwind();
    //     Gate::define('admin', function ($user){
    //         return $user->is_admin == true;
    //     });

    //     Scramble::configure()->routes(function (Route $route){
    //         return Str::startsWith($route->uri, 'api/');
    //     });
        

    //     //Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    // }
}
