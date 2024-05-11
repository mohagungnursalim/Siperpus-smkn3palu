<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface ProfileRepositoryInterface
{
    public function updateProfile(User $user, array $data): void;

    public function deleteUser(User $user): void;
}
