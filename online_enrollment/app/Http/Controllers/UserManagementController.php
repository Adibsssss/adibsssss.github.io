<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::whereDoesntHave('roles', function($query) {
            $query->where('name', 'admin');
        })->paginate(10); 

        return view('admin.users.index', compact('users'));
    }


    public function create()
    {
        $roles = Role::all(); 
        return view('admin.users.create', compact('roles')); 
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        
        if ($request->hasFile('avatar')) {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $path = $request->file('avatar')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        $user->save(); 

        $user->roles()->sync($request->input('roles', []));
        
        $user->updated_at = now();  
        $user->save();  

        return redirect()->route('admin.users.edit', $user)->with('success', 'User updated successfully.');
    }
    

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}