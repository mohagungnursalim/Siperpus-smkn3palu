<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\ProfileRepositoryInterface;

class ProfileRepository implements ProfileRepositoryInterface
{
    public function updateProfile(User $user, array $data): void
    {
        $user->fill($data);

        if (array_key_exists('email', $data) && $user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();
    }

    public function deleteUser(User $user): void
    {
        $user->delete();
    }
}
