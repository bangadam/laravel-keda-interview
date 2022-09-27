<?php

namespace App\Repositories\User;

use App\Models\User;

class UserRepository implements IUserRepository
{
    public function getCustomers($request): array
    {
        $user = new User();

        $user = $user->whereHas('userType', function ($query) {
            $query->where('name', 'customer');
        });

        $user = $user->orderBy('created_at', 'desc')->get();

        return $user->toArray();
    }

    public function deleteCustomer($id): bool
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();

            return true;
        }

        return false;
    }
}
