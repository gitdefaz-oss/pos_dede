<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Menampilkan daftar user
     */
    public function index(SearchRequest $request)
    {
        $keyword = $request->input('search');

        if ($keyword) {
            $users = User::whereRaw("MATCH(name, email) AGAINST(? IN BOOLEAN MODE)", [$keyword])
                ->paginate(10)
                ->withQueryString();
        } else {
            $users = User::query()->paginate(10)->withQueryString();
        }

        return view('users.index', compact('users'));
    }

    /**
     * Menampilkan form tambah user
     */
    public function create()
    {
        $roles = Role::all();

        return view('users.create', compact('roles'));
    }

    /**
     * Menyimpan user baru ke database
     */
    public function store(StoreRequest $request)
    {
        $dataReq = $request->validated();

        User::create([
            'name'     => $dataReq['name'],
            'email'    => $dataReq['email'],
            'password' => Hash::make($dataReq['password']),
            'role_id'  => $dataReq['role_id'],
        ]);

        return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit user
     */
    public function edit(User $user)
    {
        $roles = Role::all();

        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Memperbarui data user di database
     */
    public function update(UpdateRequest $request, User $user)
    {
        $dataReq = $request->validated();

        $user->name    = $dataReq['name'];
        $user->email   = $dataReq['email'];
        $user->role_id = $dataReq['role_id'];

        if (!empty($dataReq['password'])) {
            $user->password = Hash::make($dataReq['password']);
        }

        $user->save();

        return redirect()->route('admin.users.edit', $user->id)->with('success', 'User updated');
    }

    /**
     * Menghapus user dari database
     */
    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success', 'User deleted');
    }
}