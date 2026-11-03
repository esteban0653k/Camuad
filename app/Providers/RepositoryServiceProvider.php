<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\UsuarioRepositoryInterface;
use App\Repositories\UsuarioRepository;
use App\Interfaces\RolRepositoryInterface;
use App\Repositories\RolRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            UsuarioRepositoryInterface::class,
            UsuarioRepository::class
        );

        $this->app->bind(
            RolRepositoryInterface::class,
            RolRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}