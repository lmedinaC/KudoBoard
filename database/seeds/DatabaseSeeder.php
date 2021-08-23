<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = new Faker();
        DB::table('users')->insert([
            'name' => 'adminTest',
            'email' => 'adminTest@gmail.com',
            'password' => Hash::make("adminTest1234"),
        ]);

        /**
         * Create factory apartment with theirs relationships
         */
        factory(App\Apartment::class, 2)->create()->each(function ($apartment) {
            $apartment->provincies()
                ->saveMany(factory(App\Provincy::class, 2)->make())
                ->each(function ($p) {
                    $p->districts()
                        ->save(factory(App\District::class)->make());
                });
        });

        factory(App\Concessionaire::class, 2)->create()->make();


        DB::table('customers')->insert([
            'name' => 'CUSTOMER',
            'last_name' => "CUSTOMER TEST",
            'state' => 1,
            'phone_number' => 999999999,
            'birth_date' => '1998/10/10',
            'address' => "ADRESS TEST",
            'district_id' => 1,
            'concessionaire_id' => 1
        ]);

        DB::table('customers')->insert([
            'name' => 'CUSTOMER2',
            'last_name' => "CUSTOMER TEST",
            'state' => 1,
            'phone_number' => 999999999,
            'birth_date' => '1998/10/10',
            'address' => "ADRESS TEST",
            'district_id' => 1,
            'concessionaire_id' => 1
        ]);


    }
}
