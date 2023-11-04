<?php

namespace App\Console\Commands;

use Domain\PhpTop\DataTransferObjects\Fact\FactData;
use Domain\PhpTop\DataTransferObjects\Fact\RandomFactsViewModel;
use Domain\PhpTop\Events\GetRandomFactsEvent;
use Domain\PhpTop\Models\Fact;
use Illuminate\Console\Command;

class GetRandomFacts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-random-facts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get random 4 facts about PHP';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $randomFacts = new RandomFactsViewModel(FactData::collection(Fact::all()->random(4)));
        GetRandomFactsEvent::dispatch($randomFacts);
        $this->info('Get random 4 facts about PHP!');
    }
}
