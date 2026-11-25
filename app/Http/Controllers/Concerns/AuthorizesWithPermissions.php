<?php
 
namespace App\Http\Controllers\Concerns;
 
use Illuminate\Routing\Controllers\Middleware;
 
trait AuthorizesWithPermissions
{
 
    abstract public static function permissions(): array;
 
    public static function middleware(): array
    {
        $grouped = [];
 
        foreach (static::permissions() as $method => $permission) {
            $grouped[$permission][] = $method;
        }
 
        return collect($grouped)
            ->map(fn (array $methods, string $permission) => new Middleware(
                "permission:{$permission}",
                only: $methods,
            ))
            ->values()
            ->all();
    }
}