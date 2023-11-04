<?php

namespace app\Http\Controllers\PhpTop\Fact;

use App\Http\Controllers\Controller;
use Domain\PhpTop\DataTransferObjects\Fact\FactData;
use Domain\PhpTop\DataTransferObjects\Fact\RandomFactsViewModel;
use Domain\PhpTop\Events\GetRandomFactsEvent;
use Domain\PhpTop\Models\Fact;
use Domain\Shared\Events\GetUserEvent;

class GetRandomFactsController extends Controller
{
    public function __invoke(): RandomFactsViewModel
    {
        $randomFacts = new RandomFactsViewModel(FactData::collection(Fact::all()->random(4)));
        GetRandomFactsEvent::dispatch($randomFacts);
        return $randomFacts;
    }
}
