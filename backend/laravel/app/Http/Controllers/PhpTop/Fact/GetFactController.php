<?php

namespace app\Http\Controllers\PhpTop\Fact;

use App\Http\Controllers\Controller;

use Domain\PhpTop\DataTransferObjects\Fact\FactData;
use Domain\PhpTop\Models\Fact;
use Domain\PhpTop\ViewModels\Fact\FactViewModel;


class GetFactController extends Controller
{
    public function __invoke(Fact $fact): FactViewModel
    {
        return new FactViewModel(FactData::from($fact));
    }
}
