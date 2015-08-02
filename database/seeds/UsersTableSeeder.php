<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

        foreach(range(0,30) as $r)
        {
            $user = \Faker\Factory::create();
            App\User::create([
                'username' => $user->username,
                'email' => $user->freeEmail,
                'name' => $user->name,
                'password' => Hash::make('secret')
            ]);
        }
    }
}
