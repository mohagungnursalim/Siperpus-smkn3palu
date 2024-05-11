<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $loggedInUserId = auth()->id();
        $users = request('search')
            ? $this->userRepository->searchUsers(request('search'), $loggedInUserId)
            : $this->userRepository->getAllUsersExceptLoggedInUser($loggedInUserId);

        return view('dashboard.user.index', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'name' => 'required',
            'is_admin' => 'required|in:0,1'
        ]);

        $this->userRepository->storeUser($request->only(['email', 'name', 'is_admin']));

        return redirect('/dashboard/user')->with('success', 'Akun baru berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id)
    {
        $this->userRepository->resetPassword($id);

        return redirect('/dashboard/user')->with('success', 'Password telah direset menjadi password default!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->userRepository->deleteUser($id);

        return redirect('/dashboard/user')->with('success', 'Akun berhasil dihapus!');
    }
}
