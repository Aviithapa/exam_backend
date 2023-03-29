<?php

namespace App\Services\Role;

use Illuminate\Http\Request;
use App\Repositories\Role\RoleRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class RoleGetter
 * @package App\Services\Role
 */
class RoleGetter
{
    /**
     * @var RoleRepository
     */
    protected $roleRepository;

    /**
     * RoleGetter constructor.
     * @param RoleRepository $roleRepository
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Get paginated apartment list
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function getPaginatedList(): LengthAwarePaginator
    {
        return $this->roleRepository->getWithPagination();
    }

    /**
     * Get a single apartment
     * @param $id
     * @return Object|null
     */
    public function show($id)
    {
        return $this->roleRepository->findById($id);
    }
}
