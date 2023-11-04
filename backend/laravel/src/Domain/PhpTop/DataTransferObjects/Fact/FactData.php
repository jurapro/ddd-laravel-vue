<?php

namespace Domain\PhpTop\DataTransferObjects\Fact;

use Domain\PhpTop\Models\Fact;
use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

class FactData extends Data
{
    public function __construct(
        public readonly ?int   $id,
        public readonly string $title,
        public readonly string $text,
    )
    {
    }

    public function fromModel(Fact $model): self
    {
        return self::from([
            'id' => $model->id,
            'title' => $model->title,
            'text' => $model->text,
        ]);
    }
}
