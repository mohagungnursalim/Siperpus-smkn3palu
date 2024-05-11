<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function getAllUsersExceptLoggedInUser($loggedInUserId)
    {
        return User::where('id', '!=', $loggedInUserId)->oldest()->cursorPaginate(10)->withQueryString();
    }

    public function searchUsers($searchTerm, $loggedInUserId)
    {
        return User::where(function($query) use ($searchTerm) {
                    $query->where('name', 'like', '%' . $searchTerm . '%')
                          ->orWhere('email', 'like', '%' . $searchTerm . '%');
                })
                ->where('id', '!=', $loggedInUserId)
                ->oldest()
                ->cursorPaginate(10)->withQueryString();
    }

    public function storeUser($userData)
    {
        $userData['password'] = Hash::make('12345678');
        return User::create($userData);
    }

    public function resetPassword($userId)
    {
        $user = User::findOrFail($userId);
        $user->update([
            'password' => Hash::make('12345678')
        ]);
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();
    }
}
