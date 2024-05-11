<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function getAllUsersExceptLoggedInUser($loggedInUserId);

    public function searchUsers($searchTerm, $loggedInUserId);

    public function storeUser($userData);

    public function resetPassword($userId);

    public function deleteUser($userId);
}
