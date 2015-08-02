<?php

use Illuminate\Database\Seeder;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->truncate();

        foreach(range(0,300) as $r)
        {
            $users = \App\User::lists('id')->toArray();

            $status = \Faker\Factory::create();
            App\Status::create([
                'user_id' => $status->randomElement($users),
                'body' => $status->paragraph(),
                'created_at' => $status->dateTimeThisYear
            ]);
        }
    }
}
