<?php

namespace Domain\Shared\DataTransferObjects\User;

use Domain\Shared\Models\User\User;
use Illuminate\Http\Request;
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

    public function fromRequest(Request $request): self
    {
        return self::from([
            'id' => $request->id,
/*            'name' => $request->name,
            'email' => $request->email,*/
        ]);
    }
}
