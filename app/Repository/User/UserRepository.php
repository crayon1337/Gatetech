<?php

namespace App\Repository\User;

use App\Models\User;
use App\Repository\Eloquent\BaseRepository;

class UserRepository extends BaseRepository implements UserInterface
{
    /**
     * UserRepository constructor.
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
