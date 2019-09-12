<?php
use App\Categoria;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Categoria::truncate(); 

        $cantidadCategorias = 100;

        factory(Categoria::class,$cantidadCategorias)->create();
    }
}
