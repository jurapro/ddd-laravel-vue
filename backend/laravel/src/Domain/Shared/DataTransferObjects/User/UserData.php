<?php

namespace Domain\Shared\DataTransferObjects\User;

use Domain\Shared\Models\User\User;
use Spatie\LaravelData\Data;

class UserData extends Data
{
    public function __construct(
        public readonly ?int   $id,
        public readonly string $name,
        public readonly string $email,
    )
    {
    }

    public function fromModel(User $model): self
    {
        return self::from([
            'id' => $model->id,
            'name' => $model->name,
            'email' => $model->email,
        ]);
    }
}
