<?php

namespace App\Console\Commands;

use App\Server\BracketRoaster;
use Illuminate\Console\Command;

class BakeBracketCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bake:roundrobin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bake the tournaments brackets using round-robin algorithm';
    /**
     * @var BracketRoaster
     */
    protected $roaster;

    /**
     * Create a new command instance.
     *
     * @param BracketRoaster $roaster
     */
    public function __construct(BracketRoaster $roaster)
    {
        $this->roaster = $roaster;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info($this->roaster->checkRoastBracketsAll());
    }
}
