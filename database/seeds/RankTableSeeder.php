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
            array('name'=>'None','shortname'=>'NON','rank_points'=>'0','rank_seconds'=>0,'description'=>'<=0'),
            array('name'=>'Private','shortname'=>'PVT','rank_points'=>'1000','rank_seconds'=>60*60,'description'=>'1-1000'),
            array('name'=>'Private First Class','shortname'=>'PFC','rank_points'=>'5000','rank_seconds'=>5*60*60,'description'=>'1001-5000'),
            array('name'=>'Reserve Officer','shortname'=>'RO','rank_points'=>'10000','rank_seconds'=>10*60*60,'description'=>'5001-10000'),
            array('name'=>'Patrol Officer','shortname'=>'PO','rank_points'=>'15000','rank_seconds'=>15*60*60,'description'=>'10001-15000'),
            array('name'=>'Corporal','shortname'=>'CRP','rank_points'=>'20000','rank_seconds'=>20*60*60,'description'=>''),
            array('name'=>'Sergeant','shortname'=>'SRG','rank_points'=>'25000','rank_seconds'=>25*60*60,'description'=>''),
            array('name'=>'Master Sergeant','shortname'=>'MSG','rank_points'=>'30000','rank_seconds'=>30*60*60,'description'=>''),
            array('name'=>'Lieutenant','shortname'=>'LT','rank_points'=>'35000','rank_seconds'=>35*60*60,'description'=>''),
            array('name'=>'Captain','shortname'=>'CPT','rank_points'=>'40000','rank_seconds'=>40*60*60,'description'=>''),
            array('name'=>'Major','shortname'=>'MJR','rank_points'=>'45000','rank_seconds'=>45*60*60,'description'=>''),
            array('name'=>'Deputy Chief','shortname'=>'DCP','rank_points'=>'50000','rank_seconds'=>50*60*60,'description'=>''),
            array('name'=>'Assistant Chief','shortname'=>'ACP','rank_points'=>'60000','rank_seconds'=>60*60*60,'description'=>''),
            array('name'=>'Chief of Police','shortname'=>'COP','rank_points'=>'75000','rank_seconds'=>70*60*60,'description'=>''),
        ));
    }
}
