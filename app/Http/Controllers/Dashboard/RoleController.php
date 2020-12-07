<?php

namespace App\Http\Controllers\Dashboard;

use App\Ability;
use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    protected $adminCategories = [
        'roles',
        'users',
        'violations',
        'employees',
        'employees_violations',
        'reports',
        'conversations',
    ];
    protected $customerCategories = [
        'roles',
        'employees',
        'employees_violations',
        'reports',
        'conversations',
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $this->authorize('view_roles');
        if($request->ajax()){
            $roles = Role::get();
            return response()->json($roles);
        }
        return view('dashboard.roles.index');
    }
    public function create()
    {
        $this->authorize('create_roles');
        $userRole = auth()->user()->roles->first()->label;
        $abilities = Ability::get();
        return view('dashboard.roles.create' , [
            'abilities' => $abilities,
            'categories' => $userRole == "Super Admin" ? $this->adminCategories : $this->customerCategories
        ]);
    }
    public function store(Request $request)
    {
        $this->authorize('create_roles');
        $role = Role::create($this->validate($request, [
            'name_arabic' => 'required|string|unique:roles',
            'name_english' => 'required|string|unique:roles',
        ]));
        $abilities = Ability::get();
        foreach($abilities as $ability){
            if (request($ability->name) == "on"){
                $role->allowTo($ability);
            }
        }
        return redirect(route('dashboard.roles.index'));
    }
    public function show(Role $role)
    {
        $userRole = auth()->user()->roles->first()->label;
        return view('dashboard.roles.show', [
            'role' => $role,
            'abilities' => Ability::get(),
            'categories' => $userRole == "Super Admin" ? $this->adminCategories : $this->customerCategories,
            'role_abilities' =>$role->abilities
        ]);
    }
    public function edit(Role $role)
    {
        $this->authorize('update_roles');
        $userRole = auth()->user()->roles->first()->label;
        return view('dashboard.roles.edit', [
            'abilities' => Ability::get(),
            'categories' => $userRole == "Super Admin" ? $this->adminCategories : $this->customerCategories,
            'role_abilities' => $role->abilities,
            'role'  => $role
        ]);
    }
    public function update(Request $request, Role $role)
    {
        $this->authorize('update_roles');
        if($role->name_arabic != $request->name_arabic){
            $role->update($this->validate($request, [
                'name_arabic' => 'required|string|unique:roles',
                'name_english' => 'required|string|unique:roles',
            ]));
        }
        $abilities = Ability::get();
        foreach($abilities as $ability){
            if (request($ability->name) == "on" && !$role->abilities->contains($ability)){
                $role->allowTo($ability);
            }elseif (!isset($request[$ability->name]) && $role->abilities->contains($ability)){
                $role->disallowTo($ability);
            }
        }
        return redirect(route('dashboard.roles.index'));
    }

    public function destroy( Request $request , $id )
    {
        $this->authorize('delete_roles');
        $role = Role::find($id);
        if($request->ajax() && $role->type != 1){
            $role->delete();
            return response()->json([
                'status' => true,
                'message' => 'Item Deleted Successfully'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Can\'t Delete System Role'
            ]);
        }

    }
}
