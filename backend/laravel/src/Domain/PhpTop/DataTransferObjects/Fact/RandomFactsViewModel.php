<?php

namespace Domain\PhpTop\DataTransferObjects\Fact;

use Domain\Shared\ViewModels\ViewModel;
use Spatie\LaravelData\DataCollection;

class RandomFactsViewModel extends ViewModel
{

    public function __construct(
        public readonly DataCollection $facts
    )
    {
    }

    public function facts(): array
    {
        return $this->facts->toArray();
    }
}
