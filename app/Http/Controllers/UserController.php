<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controller;



class UserController extends Controller
{

    // Permissions Security
    public function __construct()
    {
        $this->middleware('permission:view users')->only(methods: ['index','show']);
        $this->middleware('permission:add user')->only(['create', 'store']);
        $this->middleware('permission:edit user')->only(['edit', 'update']);
        $this->middleware('permission:delete user')->only(['destroy']);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  =>  'required|string|max:255',
            'email' =>  'email',
            'password'  => 'required|string|min:8|confirmed',
            'role'     => 'required|string',

        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->assignRole($validated['role']);

        return redirect()->route('users.index')->with('success', __('users.created_successfully') );



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

        $user = User::with('roles')->findOrFail($id);

        $roles = Role::all();

        return view('users.edit', compact('user', 'roles'));

    }

    /**
     * Update the specified resource in storage.
    */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'role'  => 'required|exists:roles,name',
        ]);

        $user = User::findOrFail($id);

        $user->name  = $validated['name'];
        $user->email = $validated['email'];

        // لو الباسورد مش فاضي، نعمله Hash ونحدّثه
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        $user->syncRoles($validated['role']);

        return redirect()->route('users.index')->with('success', __('users.user_updated_successfully') );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', __('users.user_deleted_successfully') );
    }
}
