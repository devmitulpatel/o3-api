<?php

namespace App\Policies;

use App\Models\Currency;
use App\Models\User;
use App\Traits\PolicyHelper;
use Illuminate\Auth\Access\HandlesAuthorization;

class CurrencyPolicy
{
    use HandlesAuthorization;
    use PolicyHelper;

    public function before(User $user, $ability)
    {
        //
    }

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Currency $currency)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Currency $currency)
    {
        return true;
    }

    public function delete(User $user, Currency $currency)
    {
        return true;
    }

    public function restore(User $user, Currency $currency)
    {
        return true;
    }

    public function forceDelete(User $user, Currency $currency)
    {
        return true;
    }
}
