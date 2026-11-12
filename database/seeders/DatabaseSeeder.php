<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rol;
use App\Models\Usuario;
use App\Models\Categorias;
use App\Models\Proveedor;
use App\Models\Marca;
use App\Models\Producto;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        #SEEDERS ROL
       $admin = Rol::create(['nombre' => 'Administrador']);
       $super = Rol::create(['nombre' => 'Supervisor']);
       $emp = Rol::create(['nombre' => 'Empleado']);
        #SEEDERS USUARIO
       Usuario::create([
            'nombre' => 'Jondaesca',
            'email' => 'admin@test.com',
            'password' => bcrypt('123'),
            'role_id' => $admin->id, 
        ]);
       Usuario::create([
            'nombre' => 'Armando',
            'email' => 'super@test.com',
            'password' => bcrypt('123'),
            'role_id' => $super->id, 
        ]);
       Usuario::create([
            'nombre' => 'Ricolin',
            'email' => 'ricolin@test.com',
            'password' => bcrypt('123'),
            'role_id' => $emp->id, 
        ]);
        Usuario::create([
            'nombre' => 'Benito',
            'email' => 'benito@test.com',
            'password' => bcrypt('123'),
            'role_id' => $emp->id, 
        ]);
        
         #SEEDERS PROVEEDOR
       Proveedor::factory()->count(3)->create();

         #SEEDERS CATEGORIAS
       Categorias::create([
            'nombre' => 'Herramientas Manuales',
            'descripcion' => 'Martillos, alicates, destornilladores, llaves fijas/ajustables, serruchos, flexómetros.'
        ]);
        Categorias::create([
            'nombre' => 'Herramientas Eléctricas y Inalámbricas',
            'descripcion' => 'Taladros, pulidoras/esmeriles, sierras circulares, lijadoras, soldadores.'
        ]);
        Categorias::create([
            'nombre' => 'Materiales de Construcción y Obra Gris',
            'descripcion' => 'Cemento, arena, estuco, yeso, varillas, ladrillos, aditivos para concreto.'
        ]);
        Categorias::create([
            'nombre' => 'Fontanería y Plomería',
            'descripcion' => 'Tubos PVC/CPVC, accesorios, llaves de paso, grifería, cinta teflón, pegamento para PVC.'
        ]);
        Categorias::create([
            'nombre' => 'Electricidad e Iluminación',
            'descripcion' => 'Cable eléctrico, tomacorrientes, interruptores, breakers/tacos, bombillos LED, cintas aislantes.'
        ]);

         #SEEDERS MARCA
        Marca::factory()->count(5)->create(); 
        
         #SEEDERS PRODUCTO
       Producto::factory()->count(30)->create();
        

    }   
    
}