<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        $this->call([UsersTableSeeder::class]);      
        $this->call(FinalliCert::class);
        $this->call(SacramentosSeeder::class);
        $this->call(GroupIntentionsSeeder::class);
        $this->call(ClassesIntentionsSeeder::class);
        $this->call(EstadosTableSeeder::class);        
        $this->call(CountCategorSeeder::class);
    }
}
