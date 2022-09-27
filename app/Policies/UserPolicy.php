<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    // only staff can delete customers
    public function delete(User $user)
    {
        return $user->user_type_id == 2;
    }

    // only staff can view users
    public function viewAny(User $user)
    {
        return $user->user_type_id == 2;
    }
}
