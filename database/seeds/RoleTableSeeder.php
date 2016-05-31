<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();
        //insert some dummy records
        DB::table('roles')->insert(array(
            array('id' => '1','name'=>'leader','display_name'=>'Leader','description'=>'Owner and Leader of Knight of Sorrow Servers'),
            array('id' => '2','name'=>'superadmin','display_name'=>'Super Administrator','description'=>'Super Administrator of Knight of Sorrow Servers'),
            array('id' => '3','name'=>'admin','display_name'=>'Administrator','description'=>'Administrator of Knight of Sorrow Servers'),
            array('id' => '4','name'=>'elder','display_name'=>'Elder','description'=>'Elder member of Knight of Sorrow Servers'),
            array('id' => '5','name'=>'member','display_name'=>'Member','description'=>'Member of Knight of Sorrow Servers'),
            ));
    }
}
