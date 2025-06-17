<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $auth)
    {
        return $auth->hasAnyRole(['super_admin', 'admin']);
    }

    public function view(User $auth, User $user)
    {
        if ($auth->hasRole('super_admin')) return true;
        if ($auth->hasRole('admin')) return $user->association_id === $auth->association_id;
        return false;
    }

    public function create(User $auth)
    {
        return $auth->hasAnyRole(['super_admin', 'admin']);
    }

    public function update(User $auth, User $user)
    {
        if ($auth->hasRole('super_admin')) return true;
        if ($auth->hasRole('admin')) return $user->association_id === $auth->association_id;
        return false;
    }

    public function delete(User $auth, User $user)
    {
        return $this->update($auth, $user);
    }
}
