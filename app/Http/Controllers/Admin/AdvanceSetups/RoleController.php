<?php

namespace App\Http\Controllers\Admin\AdvanceSetups;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdvanceSetups\RoleResetRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        if (! userCan('roles access')) {
            abort(403);
        }

        $roles = Role::orderBy('name')->paginate(pageSize());

        return Inertia::render('Admin/Setups/Advance/Roles/Index', compact('roles'));
    }

    public function create()
    {
        if (! userCan('roles create')) {
            abort(403);
        }
        $permissions = Permission::select('id', 'module', 'group', 'name')
            ->orderBy('module', 'asc')
            ->orderBy('name', 'asc')
            ->get()->groupBy('group')->map(function ($group) {
                return $group->groupBy('module');
            });

        return Inertia::render('Admin/Setups/Advance/Roles/Create', compact('permissions'));
    }

    public function store(Request $request)
    {
        if (! userCan('roles create')) {
            abort(403);
        }

        $this->validateInput($request);
        \DB::transaction(function () use ($request) {
            $role = Role::create([
                'name' => $request->name,
                'description' => $request->description,
                'guard_name' => 'web',
            ]);
            $role->syncPermissions($request->permissions);
            // $role->givePermissionTo([1,2,3]);
        });

        return redirect(route('admin.roles.index'))->with('type', 'success')->with('message', 'New Role added successfully !!');
    }

    public function edit($role)
    {
        if (! userCan('roles edit')) {
            abort(403);
        }

        $role = Role::select('id', 'name', 'description')->with('permissions:id')->where('id', $role)->first();

        $permissions = Permission::select('id', 'module', 'group', 'name')
            ->orderBy('module', 'asc')
            ->orderBy('name', 'asc')
            ->get()->groupBy('group')->map(function ($group) {
                return $group->groupBy('module');
            });

        return Inertia::render('Admin/Setups/Advance/Roles/Create', compact('permissions', 'role'));
    }

    public function update(Request $request, $role)
    {
        if (! userCan('roles edit')) {
            abort(403);
        }

        $role = Role::findorFail($role);
        $this->validateInputforUpdate($request, $role);

        if ($role->id < 2) { // these are reserved
            $role->update($request->only('description'));
            $role->syncPermissions($request->permissions);

            return redirect(route('admin.roles.index'))->with('type', 'info')->with('message', ' "'.ucfirst($role->name).'" role name cannot be updated !!');
        } else {
            $role->update($request->only('name', 'description'));
            $role->syncPermissions($request->permissions);

            return redirect(route('admin.roles.index'))->with('type', 'success')->with('message', 'Role Updated successfully !!');
        }
    }

    public function resetPermissions(RoleResetRequest $request)
    {
        // $modules = ['tips', 'certificates', 'salon services', 'bookings', 'games/quizzes', 'games/rewards-points', 'training/preloaded-videpos', 'sales/orders', 'sales/transactions', 'sales/coupons', 'users',  'roles' ];
        return $this->seedPermission();
    }

    public function seedPermission()
    {
        /* \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
         Permission::truncate();
         \DB::statement('SET FOREIGN_KEY_CHECKS=1;');*/

        $this->createPermissions();

        Role::find(1)->givePermissionTo(Permission::all()); // admin role

        try {
            // id 2 is of "operator" role
            $role = Role::findByName('operator');
            if ($role) {
                $role->syncPermissions(['trades access', 'trades create', 'trades edit', 'trades delete', 'transfer access']);
            }
        } catch (\Exception $e) {
            info($e->getMessage());
        }
        // return $tempPermissions;
    }

    public function addOrUpdatePermissions()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Permission::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->createPermissions();
        Role::find(1)->givePermissionTo(Permission::all());

        return redirect()->back()->banner('Permissions are uptodate.');
    }

    private function createPermissions()
    {

        $modules = $this->permissionsArr();
        $tempPermissions = [];
        foreach ($modules as $group => $permissions) {
            if (! empty($permissions)) {
                foreach ($permissions as $key => $access) {
                    foreach ($access as $value) {
                        Permission::firstOrCreate(['group' => $group, 'module' => "{$key}", 'name' => "{$key} {$value}", 'guard_name' => 'web']);
                    }
                }
            } else {
                Permission::firstOrCreate(['group' => $group, 'name' => "{$group} access", 'guard_name' => 'web']);
            }
        }
    }

    private function permissionsArr(): array
    {
        $permissions = [
            'advance setup' => [
                'users' => ['access', 'create', 'edit'],
                'advance setup' => ['access'],
                'roles' => ['access', 'create', 'edit'],
            ],
            'Setup' => [
                'setup' => ['access'],
                'Cases' => ['access', 'create', 'edit', 'ledger access', 'ledger export'],
                'clients' => ['access', 'create', 'edit'],
                'currencies' => ['access', 'create', 'edit', 'bulk edit', 'ledger access', 'ledger export'],
            ],
            'accounts' => [
                'accounts' => ['access', 'create', 'edit', 'export'],
                'transactions' => ['access', 'create', 'edit', 'delete', 'export'],
            ],
            'teller-transfer' => [
                'transfer' => ['access', 'create', 'edit', 'delete', 'export'],
            ],
            'Trades' => [
                'trades' => ['access', 'create', 'edit', 'delete', 'trash', 'profit', 'export', 'last average rate', 'currency balance', 'summary', 'add client'],
            ],

        ];

        return $permissions;
    }

    private function validateInput($request)
    {
        $request->validate([
            'name' => 'required|unique:roles',
        ],
            [
                'name.required' => 'Name of role is empty.',
                'name.unique' => 'Name of role is taken please add unique.',
            ]

        );
    }

    private function validateInputforUpdate($request, $role)
    {
        $request->validate([
            'name' => 'required',
            'name' => [Rule::unique('roles')->ignore($role->id)],
        ],
            [
                'name.required' => 'Name of role is empty.',
                'name.unique' => 'Name of role is taken please add unique.',
            ]

        );
    }
}
