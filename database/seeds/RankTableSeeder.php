<?php

use Illuminate\Database\Seeder;

class RankTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ranks')->delete();
        //insert some dummy records
        DB::table('ranks')->insert(array(
            array('id' => '1','name'=>'None','shortname'=>'NON','rank_points'=>'0','rank_seconds'=>0,'description'=>'<=0'),
            array('id' => '2','name'=>'Private','shortname'=>'PVT','rank_points'=>'1000','rank_seconds'=>60*60,'description'=>'1 - 1000'),
            array('id' => '3','name'=>'Private First Class','shortname'=>'PFC','rank_points'=>'5000','rank_seconds'=>5*60*60,'description'=>'1001 - 5000'),
            array('id' => '4','name'=>'Reserve Officer','shortname'=>'RO','rank_points'=>'10000','rank_seconds'=>10*60*60,'description'=>'5001 - 10000'),
            array('id' => '5','name'=>'Patrol Officer','shortname'=>'PO','rank_points'=>'15000','rank_seconds'=>15*60*60,'description'=>'10001 - 15000'),
            array('id' => '6','name'=>'Corporal','shortname'=>'CRP','rank_points'=>'20000','rank_seconds'=>20*60*60,'description'=>'15001 - 20000'),
            array('id' => '7','name'=>'Sergeant','shortname'=>'SRG','rank_points'=>'25000','rank_seconds'=>25*60*60,'description'=>'20001 - 25000'),
            array('id' => '8','name'=>'Master Sergeant','shortname'=>'MSG','rank_points'=>'30000','rank_seconds'=>30*60*60,'description'=>'25001 - 30000'),
            array('id' => '9','name'=>'Lieutenant','shortname'=>'LT','rank_points'=>'35000','rank_seconds'=>35*60*60,'description'=>'30001 - 35000'),
            array('id' => '10','name'=>'Captain','shortname'=>'CPT','rank_points'=>'40000','rank_seconds'=>40*60*60,'description'=>'35001 - 40000'),
            array('id' => '11','name'=>'Major','shortname'=>'MJR','rank_points'=>'45000','rank_seconds'=>45*60*60,'description'=>'40001 - 45000'),
            array('id' => '12','name'=>'Deputy Chief','shortname'=>'DCP','rank_points'=>'50000','rank_seconds'=>50*60*60,'description'=>'45001 - 50000'),
            array('id' => '13','name'=>'Assistant Chief','shortname'=>'ACP','rank_points'=>'60000','rank_seconds'=>60*60*60,'description'=>'50000 - 60000'),
            array('id' => '14','name'=>'Chief of Police','shortname'=>'COP','rank_points'=>'75000','rank_seconds'=>70*60*60,'description'=>'>60000'),
        ));
    }
}
