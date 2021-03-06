<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ConfigurationSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(DocentesSeeder::class);
        $this->call(JornadaSemestreSeeder::class);
    }
}
