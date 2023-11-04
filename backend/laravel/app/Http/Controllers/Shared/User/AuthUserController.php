<?php

namespace app\Http\Controllers\Shared\User;

use App\Http\Controllers\Controller;

use Domain\Shared\DataTransferObjects\User\UserData;
use Domain\Shared\Models\User\User;
use Domain\Shared\ViewModels\User\UserTokensViewModel;
use Opekunov\Centrifugo\Centrifugo;


class AuthUserController extends Controller
{
    public function __invoke(User $user): UserTokensViewModel
    {

        $tokenAccess = $user->createToken(rand())->plainTextToken;

        $centrifugo = new Centrifugo();
        $expire = time() + 60 * 60 * 24;
        $tokenCentrifugo = $centrifugo->generateConnectionToken((string)$user->id, $expire, [
            'name' => $user->fullName,
        ]);

        return new UserTokensViewModel(UserData::from($user), $tokenAccess, $tokenCentrifugo);
    }
}
