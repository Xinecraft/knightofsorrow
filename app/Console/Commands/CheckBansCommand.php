<?php

namespace App\Console\Commands;

use App\Ban;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckBansCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:bans';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for ban-list and un-ban all expired bans.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $bans = Ban::where('status',true)->get();

        $count = 0;

        foreach($bans as $ban)
        {
            if($ban->banned_till != null && $ban->banned_till <= Carbon::now())
            {
                $count++;
                $ban->status = false;
                $ban->updated_by = "Bans-Manager";
                $ban->updated_by_site = true;
                $ban->save();
                $ban->tellServerToRemove("Bans-Manager");
            }
        }

        $this->info($count." expired bans cleared!");
    }
}
