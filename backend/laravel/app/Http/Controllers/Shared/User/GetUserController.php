<?php

namespace app\Http\Controllers\Shared\User;

use App\Http\Controllers\Controller;

use Domain\Shared\DataTransferObjects\User\UserData;
use Domain\Shared\Models\User\User;
use Domain\Shared\ViewModels\User\UserProfileViewModel;


class GetUserController extends Controller
{
    public function __invoke(User $user): UserProfileViewModel
    {
        return new UserProfileViewModel(UserData::from($user));
    }
}
