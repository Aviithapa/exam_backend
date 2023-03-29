<?php

namespace App\Services\Role;

use App\Repositories\Role\RoleRepository;

class RoleCreator
{
    protected $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function store($data)
    {
        return $this->roleRepository->create($data);
    }
}
