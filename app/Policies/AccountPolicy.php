<?php

namespace App\Policies;

use App\Models\{User, Account};
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function delete(User $user, Account $account)
    {
        return $user->id == $account->user_id;
    }

    public function update(User $user, Account $account)
    {
        return $user->id == $account->user_id;
    }
}
