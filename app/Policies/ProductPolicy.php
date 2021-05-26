<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        //
    }

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Product $product)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Product $product)
    {
        return true;
    }

    public function delete(User $user, Product $product)
    {
        return true;
    }

    public function restore(User $user, Product $product)
    {
        return true;
    }

    public function forceDelete(User $user, Product $product)
    {
        return true;
    }
}
