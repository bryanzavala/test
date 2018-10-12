<?php

use Illuminate\Database\Seeder;
// use Illuminate\Database\Eloquent;
// use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        Eloquent::unguard();
        $path = 'database/seeds/transactions.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('Transactions table seeded!');
    }
}
