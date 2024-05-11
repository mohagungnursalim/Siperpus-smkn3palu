<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Repositories\Interfaces\ProfileRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    protected ProfileRepositoryInterface $profileRepository;

    public function __construct(ProfileRepositoryInterface $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    /**
     * Display the user's profile form.
     */
    public function index(): View
    {
        $user = auth()->user();

        return view('profile.index', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();

        $this->profileRepository->updateProfile($user, $data);

        return redirect('/dashboard/profile')->with('success_informasi', 'Profil telah diperbarui!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(): RedirectResponse
    {
        $user = auth()->user();

        $this->profileRepository->deleteUser($user);

        auth()->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    }
}