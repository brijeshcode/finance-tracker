<?php

namespace App\Http\Controllers\Admin\AdvanceSetups;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdvanceSetups\UserCreateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        /* if(! userCan('users access')){
            abort(403);
        } */

        $users = User::when($request->search, function ($query, $search) {
            $query->where('name', 'like', '%'.$search.'%');
            $query->orWhere('email', 'like', '%'.$search.'%');
            $query->orWhere('note', 'like', '%'.$search.'%');
        })
            ->withoutGlobalScopes()
            ->orderBy('id', 'desc')
            ->paginate(pageSize())
            ->withQueryString();

        return Inertia::render('Admin/Setups/Advance/Users/Index', compact('users'));
    }

    public function create()
    {
        if (! userCan('users create')) {
            abort(403);
        }

        $roles = Role::select('id', 'name')->orderBy('name')->get();

        return Inertia::render('Admin/Setups/Advance/Users/Create', compact('roles'));
    }

    public function store(UserCreateRequest $request)
    {
        if (! userCan('users access')) {
            abort(403);
        }

        $this->validateInput($request);
        \DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'password' => bcrypt($request->password),
                // 'active' => $request->active,
                'note' => $request->note,
            ]);
            $user->assignRole($request->role);
        });

        return redirect(route('admin.users.index'))->with('type', 'success')->with('message', 'User added successfully !!');
    }

    public function edit(Request $request, $user)
    {
        if (! userCan('users edit')) {
            abort(403);
        }

        $editUser = User::with('roles:id,name')
            ->withoutGlobalScopes()
            ->findorFail($user);
        $roles = Role::select('id', 'name')->orderBy('name')->get();

        return Inertia::render('Admin/Setups/Advance/Users/Create', compact('editUser', 'roles'));
    }

    public function update(Request $request, $user)
    {

        if (! userCan('users edit')) {
            abort(403);
        }

        $user = User::withoutGlobalScopes()->findorFail($user);

        $this->updateValidation($request, $user);
        \DB::transaction(function () use ($request, $user) {
            $user->syncRoles($request->role);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->note = $request->note;
            $user->active = $request->active;

            if ($request->password != '') {
                $user->password = bcrypt($request->password);
            }
            $user->save();

        });

        return redirect(route('admin.users.index'))->with('type', 'success')->with('message', 'User updated successfully !!');
    }

    public function destroy(User $user)
    {
        // code...
    }

    private function validateInput($request)
    {
        $request->validate([
            'name' => 'required|unique:users|max:255',
            'email' => 'required|unique:users|email',
            'mobile' => 'required|unique:users',
            'password' => 'required|min:4',
            'role' => 'required',
        ]);
    }

    private function updateValidation($request, User $user)
    {
        $request->validate([
            'name' => 'required||max:255',
            'mobile' => 'required|numeric|digits_between:10,11',
            'email' => 'required|email',
            'name' => [Rule::unique('users')->ignore($user->id)],
            'email' => [Rule::unique('users')->ignore($user->id)],
            'mobile' => [Rule::unique('users')->ignore($user->id)],
            'role' => 'required',
        ],
            [
                'name.required' => 'User name is empty.',
                'name.unique' => 'User name is not unique.',
                'email.required' => 'User email is empty.',
                'email.unique' => 'User email is already taken.',
            ]
        );
    }
}
