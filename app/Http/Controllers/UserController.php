<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Models\LogActivity;
use App\Models\User;
use App\Models\UserLevel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        return view('pages.user.index', ['user' => $user]);
    }

    public function create()
    {
        $level = UserLevel::all();
        return view('pages.user.create', ['levels' => $level]);
    }

    // YourController.php

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'id_level' => 'required|exists:users_level,id',
        ]);

        $user = User::create([
            'nama' => $validatedData['nama'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'id_level' => $validatedData['id_level'],
        ]);

        return redirect()->route('list-user')->with('success', 'User successfully created.');
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        $level = UserLevel::all();
        return view('pages.user.edit', ['levels' => $level, 'user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
            'id_level' => 'required|exists:users_level,id',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'nama' => $validatedData['nama'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'id_level' => $validatedData['id_level'],
        ]);

        return redirect()->route('list-user')->with('success', 'User successfully updated.');
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route('list-user')->with('success', 'Menu deleted successfully');
    }
}
