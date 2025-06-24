<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    // public function viewAny(User $auth): bool
    // {
    //     return $auth->hasAnyRole(['superadmin', 'admin', 'board', 'supervisor']);
    // }

    // public function view(User $auth, User $user): bool
    // {
    //     if ($auth->hasRole('superadmin'))
    //         return true;
    //     return $auth->association_id === $user->association_id;
    // }

    // public function create(User $auth): bool
    // {
    //     return $auth->hasAnyRole(['superadmin', 'admin', 'board', 'supervisor']);
    // }

    // public function update(User $auth, User $user): bool
    // {
    //     // Superadmin can edit anyone
    //     if ($auth->hasRole('superadmin'))
    //         return true;

    //     // Users can only edit others in their same association
    //     if ($auth->association_id !== $user->association_id)
    //         return false;

    //     // Admin can edit members, board, and supervisors (but not other admins)
    //     if ($auth->hasRole('admin')) {
    //         return $user->hasAnyRole(['member', 'board', 'supervisor']);
    //     }

    //     // Board can edit members and supervisors
    //     if ($auth->hasRole('board')) {
    //         return $user->hasAnyRole(['member', 'supervisor']);
    //     }

    //     // Supervisor can only edit members
    //     if ($auth->hasRole('supervisor')) {
    //         return $user->hasRole('member');
    //     }

    //     // Members cannot edit anyone (including themselves via UI)
    //     return false;
    // }
    // public function delete(User $auth, User $user): bool
    // {
    //     if ($auth->hasRole('superadmin') && $auth->id !== $user->id)
    //         return true;
    //     if ($auth->id === $user->id)
    //         return false;
    //     if ($auth->association_id !== $user->association_id)
    //         return false;
    //     if ($auth->hasRole('admin') && !$user->hasAnyRole(['admin', 'superadmin']))
    //         return true;
    //     return false;
    // }
}