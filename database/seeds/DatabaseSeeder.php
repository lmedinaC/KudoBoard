<?php

use App\Guest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;
use PhpParser\Node\Expr\FuncCall;

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

        /**
         * Create a user test
         */
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make("adminTest1234"),
        ]);

        DB::table('users')->insert([
            'name' => 'Joca',
            'email' => 'jocaTest@gmail.com',
            'password' => Hash::make("adminTest1234"),
        ]);

        factory(App\User::class, 8)->create()->make();

        for($i = 0 ; $i<10 ; $i++){
            DB::table('workers')->insert([
                'user_id' => $i+1,
            ]);
        };

        /**
         * create example boards
         */
        DB::table('boards')->insert([
            'description' => 'Joca’s Birthday',
            'start_date' => '2021/08/31',
            'end_date' => null,
            'num_max_guest' => 10,
            'owner_id' => 1,
        ]);

        DB::table('boards')->insert([
            'description' => 'OpenOÆce Project',
            'start_date' => null,
            'end_date' => '2021/07/31',
            'num_max_guest' => 10,
            'owner_id' => 1,
        ]);

        DB::table('boards')->insert([
            'description' => 'KudoBoard TeamWork',
            'start_date' => null,
            'end_date' => null,
            'num_max_guest' => 10,
            'owner_id' => 2,
        ]);

        /**
         * create example recipients
         */
        DB::table('recipients')->insert([
            'board_id' => 1,
            'recipient_id' => 2,
        ]);

        for($i = 0 ; $i<10 ; $i++){
            DB::table('recipients')->insert([
                'board_id' => 2,
                'recipient_id' => $i+1,
            ]);
            DB::table('recipients')->insert([
                'board_id' => 3,
                'recipient_id' => $i+1,
            ]);
        };

        /**
         * create example guest 
         */
        for($i = 0 ; $i<3 ; $i++){
            for($j=0;$j<10;$j++){
                if($i!= 0 || $j != 1  ){
                    DB::table('guests')->insert([
                        'board_id' => $i+1,
                        'guest_id' => $j+1,
                    ]);
                }
            }
        };

        /**
         * create factory post
         */
        $guests = App\Guest::whereIn('board_id' , [2,3])->get();
        $guests->each(function ($guest) {
            $guest->publications()->saveMany(factory(App\Publication::class, 2)->make());
        });

    }
}
