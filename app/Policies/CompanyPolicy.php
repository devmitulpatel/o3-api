<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use App\Traits\PolicyHelper;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
{
    use HandlesAuthorization,PolicyHelper;

    public function before(User $user, $ability)
    {
        //
    }

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Company $company)
    {
        return true;
    }

    public function create(User $user)
    {
        return $this->aboveUser($user);
    }

    public function update(User $user, Company $company)
    {
        return $this->aboveUser($user);
    }

    public function delete(User $user, Company $company)
    {
        return $this->aboveUser($user);
    }

    public function restore(User $user, Company $company)
    {
        return $this->aboveUser($user);
    }

    public function forceDelete(User $user, Company $company)
    {
        return $this->onlySuperAdmin($user);
    }


}
