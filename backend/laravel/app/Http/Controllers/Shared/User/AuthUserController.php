<?php

namespace app\Http\Controllers\Shared\User;

use App\Http\Controllers\Controller;

use Domain\Shared\Models\User\User;
use Opekunov\Centrifugo\Centrifugo;


class AuthUserController extends Controller
{
    public function __invoke(User $user): array
    {

        $centrifugo = new Centrifugo();

        $tokenAccess = $user->createToken(rand());

        $expire = time() + 60 * 60 * 24;
        $tokenCentrifugo = $centrifugo->generateConnectionToken((string)$user->id, $expire, [
            'name' => $user->fullName,
        ]);

        return ['tokenAccess' => $tokenAccess, 'tokenCentrifugo' => $tokenCentrifugo, 'user' => $user];
    }
}
