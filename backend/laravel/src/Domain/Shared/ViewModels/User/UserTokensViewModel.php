<?php

namespace Domain\Shared\ViewModels\User;

use Domain\Shared\DataTransferObjects\User\UserData;
use Domain\Shared\ViewModels\ViewModel;

class UserTokensViewModel extends ViewModel
{

    public function __construct(
        public readonly UserData $user,
        public readonly string   $tokenAccess,
        public readonly string   $tokenCentrifugo,
    )
    {
    }

    public function tokenAccess(): string
    {
        return $this->tokenAccess;
    }

    public function tokenCentrifugo(): string
    {
        return $this->tokenCentrifugo;
    }

    public function user(): UserData
    {
        return $this->user;
    }
}
