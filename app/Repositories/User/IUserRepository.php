<?php

namespace App\Repositories\User;

interface IUserRepository
{
    public function getCustomers($request): array;
    public function deleteCustomer($id): bool;
}
