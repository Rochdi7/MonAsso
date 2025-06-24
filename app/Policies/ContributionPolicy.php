<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Contribution;
use Illuminate\Auth\Access\Response;

class ContributionPolicy
{
    /**
     * Superadmin can perform any action on any resource.
     * This method is called before any other policy method.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('superadmin')) {
            return true;
        }
        return null; // Let the policy methods handle other roles
    }

    /**
     * Determine whether the user can view any contributions (list).
     * Admin, Board, and Superadmin have 'view contributions' permission.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view contributions');
    }

    /**
     * Determine whether the user can view a specific contribution.
     * Admin and Board can view contributions from their own association.
     */
    public function view(User $user, Contribution $contribution): bool
    {
        return $user->can('view contributions') && $user->association_id === $contribution->association_id;
    }

    /**
     * Determine whether the user can create contributions.
     * Admin and Board can create contributions.
     */
    public function create(User $user): bool
    {
        return $user->can('create contributions');
    }

    /**
     * Determine whether the user can update a contribution.
     * Admin and Board can update contributions from their own association.
     */
    public function update(User $user, Contribution $contribution): bool
    {
        return $user->can('edit contributions') && $user->association_id === $contribution->association_id;
    }

    /**
     * Determine whether the user can delete a contribution.
     * Only Admin can delete contributions from their own association. Board cannot delete.
     */
    public function delete(User $user, Contribution $contribution): bool
    {
        // 'delete contributions' permission is only given to Admin (and Superadmin) in seeder.
        // Board does NOT have 'delete contributions' permission, so $user->can() will return false for them.
        return $user->can('delete contributions') && $user->association_id === $contribution->association_id;
    }

    // Add restore and forceDelete methods if using soft deletes
    public function restore(User $user, Contribution $contribution): bool
    {
        return false;
    }

    public function forceDelete(User $user, Contribution $contribution): bool
    {
        return false;
    }
}
