<?php

namespace App\Services\User;

use App\Repositories\User\UserRepository;
use Exception;

class UserUpdater
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }



    public function delete($id)
    {
        return $this->userRepository->delete($id);
    }

    public function update($data, $id)
    {
        try {
            return $this->userRepository->update($data, $id);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
