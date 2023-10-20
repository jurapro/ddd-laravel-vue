<?php

namespace App\Http\Controllers\Shared\User;

use App\Http\Controllers\Controller;
use Domain\Shared\DataTransferObjects\User\UserData;
use Domain\Shared\Models\User\User;
use Domain\Shared\ViewModels\User\UsersProfileViewModel;

class GetUsersController extends Controller
{
    public function __invoke(): UsersProfileViewModel
    {
        return new UsersProfileViewModel(UserData::collection(User::all()));
    }
}
