<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $loggedInUser = auth()->user();

        // menampilkan semua user,selain user yang login
        $users = User::where('id', '!=', $loggedInUser->id)->oldest()->cursorPaginate(10)->WithQueryString();

        if (request('search')) {
            $users = User::where(function($query) {
                            $query->where('name', 'like', '%' . request('search') . '%')
                                  ->orWhere('email', 'like', '%' . request('search') . '%');
                        })
                        ->where('id', '!=', $loggedInUser->id)
                        ->oldest()
                        ->cursorPaginate(10)->WithQueryString();
        }
        

        return view('dashboard.user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email', 
            'name'   => 'required',
            'is_admin' => 'required|in:0,1'  
        ]);

        
        User::create([
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'is_admin' => $request->input('is_admin'),
            'password' => Hash::make('12345678')
            
        ]);

        return redirect('/dashboard/user')->with('success', 'Akun baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id)
    {
        $user = User::findOrFail($id);
        $user->update([
                'password' => Hash::make('12345678') // Reset password menjadi default
            ]);
    
    
        return redirect('/dashboard/user')->with('success', 'Password telah di reset menjadi password default!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        
        $user->delete();

        return redirect('/dashboard/user')->with('success', 'Akun berhasil dihapus!');
    }
}
