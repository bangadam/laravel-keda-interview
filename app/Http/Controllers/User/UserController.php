<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\User\IUserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getCustomers(Request $request)
    {
        try {
            $this->authorize('viewAny', User::class);

            $response = $this->userRepository->getCustomers($request);

            return $this->successResponse($response, 'Users retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $this->authorize('delete', auth()->user());

            $response = $this->userRepository->deleteCustomer($id);

            if ($response) {
                return $this->successResponse([], 'User deleted successfully');
            }

            return $this->errorResponse('User not found', [], 404);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
