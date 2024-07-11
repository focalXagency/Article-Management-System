<?php


namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UpdateUserRequest;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles:name')
            ->whereHas('roles', function ($query) {
                $query->where('name', '!=', 'Author');
            })
            ->select('id', 'name', 'email')->get();

        return view('users.show', compact('users'));
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
    public function store(UserStoreRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        if (isset($request->is_admin)) {
            $user->assignRole('Admin');
        } else {
            $user->assignRole('Member');
        }


        return redirect()->route('user.index');
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
    public function edit(int $id)
    {
        $user = User::findOrFail($id);
        return view('users.update', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update([
            $user->name = $request->name,
            $user->email = $request->email,
            
        ]);

        if ($request->has('password')) {
            $user->password = Hash::make($request->input('password'));
        }
        if (isset($request->is_admin)) {
            $user->assignRole('Admin');
            $user->removeRole('Member');
        } else {
            $user->assignRole('Member');
            $user->removeRole('Admin');
        }
        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            if ($user->name == 'admin') {
                return redirect()->back()->with('faild', 'you can not delete the admin account');
            } else {
                $user->delete();
                return redirect()->route('user.index')->with('success', 'User deleted successfully.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while deleting the user.');
        }
    }
}
