<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Interfaces\ClienteInterface;
use App\Repositories\ClienteRepository;

use App\Interfaces\MarcaInterface;
use App\Repositories\MarcaRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ClienteInterface::class, ClienteRepository::class);
        $this->app->bind(MarcaInterface::class, MarcaRepository::class);
    }

    public function boot(): void
    {
        
    }
}