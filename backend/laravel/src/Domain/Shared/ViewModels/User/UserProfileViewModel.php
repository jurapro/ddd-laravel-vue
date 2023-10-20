<?php

namespace Domain\Shared\ViewModels\User;

use Domain\Shared\DataTransferObjects\User\UserData;
use Domain\Shared\ViewModels\ViewModel;

class UserProfileViewModel extends ViewModel
{

    public function __construct(
        public readonly UserData $user
    )
    {
    }

    public function data(): UserData
    {
        return $this->user;
    }
}
