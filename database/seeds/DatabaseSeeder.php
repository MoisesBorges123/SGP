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
        $this->call(TypeCarSeeder::class);
        $this->call(PaymentSeeder::class);
        $this->call(PessoasTableSeeder::class);
        $this->call(PriceCarsTableSeeder::class);
        $this->call(PriceMotocyclesTableSeeder::class);
        $this->call(TablePriceTableSeeder::class);
        $this->call(VehicleTableSeeder::class);
        $this->call(TimeparkingTableSeeder::class);
        $this->call(PaymentsTableSeeder::class);
        $this->call(ParkingTableSeeder::class);
        $this->call(TelefoneTableSeeder::class);
        $this->call(ScheduleCelebrationTableSeeder::class);
        $this->call(IntentionScopesTableSeeder::class);
        $this->call(IntentionsTableSeeder::class);
    }
}
