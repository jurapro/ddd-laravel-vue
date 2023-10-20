<?php

namespace Domain\Shared\ViewModels\User;

use Domain\Shared\DataTransferObjects\User\UserData;
use Domain\Shared\ViewModels\ViewModel;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Spatie\LaravelData\DataCollection;

class UsersProfileViewModel extends ViewModel
{
    private const PER_PAGE = 5;

    public function __construct(
        public readonly DataCollection $users
    )
    {
    }

    public function users(): LengthAwarePaginator
    {
        $items = $this->users->toCollection();

        return new LengthAwarePaginator(
            $items->slice(self::PER_PAGE * (request('page') - 1))->values(),
            count($items),
            self::PER_PAGE,
            (int)request('page'),
            [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => 'page',
            ]
        );
    }
}
