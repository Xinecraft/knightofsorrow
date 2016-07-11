<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Server\Interfaces\PlayerTotalRepositoryInterface;

class CalculatePlayerTotalCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:player-total';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate and feed the player_totals table with data.';

    /**
     * The instance of PlayerTotal Repository
     *
     * @var \App\Server\Interfaces\PlayerTotalRepositoryInterface
     */
    protected $playerTotal;

    /**
     * Create a new command instance.
     *
     * @param PlayerTotalRepositoryInterface $playerTotal
     */
    public function __construct(PlayerTotalRepositoryInterface $playerTotal)
    {
        $this->playerTotal = $playerTotal;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info($this->playerTotal->calculate());
    }
}
