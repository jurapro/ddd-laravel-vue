<?php

namespace Domain\PhpTop\ViewModels\Fact;


use Domain\PhpTop\DataTransferObjects\Fact\FactData;
use Domain\Shared\ViewModels\ViewModel;

class FactViewModel extends ViewModel
{

    public function __construct(
        public readonly FactData $fact
    )
    {
    }

    public function title(): string
    {
        return $this->fact->title;
    }

    public function text(): string
    {
        return $this->fact->text;
    }
}
