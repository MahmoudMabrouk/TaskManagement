<?php

namespace App\Services;


use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{

    const COUNT = 20;
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser($userData)
    {
        return $this->userRepository->create($userData);
    }

    public function updateUser($userData, $user)
    {
        return $this->userRepository->update($user->id, $userData);
    }

    public function deleteUser($user)
    {
        return $this->userRepository->delete($user->id);
    }
}
