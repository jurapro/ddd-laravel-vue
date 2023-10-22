<?php

namespace app\Http\Controllers\Shared\User;

use App\Http\Controllers\Controller;

use Domain\Shared\DataTransferObjects\User\UserData;
use Domain\Shared\Events\SendMessageEvent;
use Domain\Shared\Models\User\User;
use Domain\Shared\ViewModels\User\UserProfileViewModel;
use Opekunov\Centrifugo\Centrifugo;


class GetUserController extends Controller
{
    public function __invoke(User $user): UserProfileViewModel
    {
        //SendMessageEvent::dispatch("Test WS");
        $centrifugo = new Centrifugo();
        $centrifugo->publish('channel', ['value' => 'Hello world']);
        return new UserProfileViewModel(UserData::from($user));
    }
}
