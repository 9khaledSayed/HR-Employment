<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Role;
use App\Employee;
use App\Scopes\ParentScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{

    public function index(Request $request)
    {
        $this->authorize('view_users');
        if ($request->ajax()){
            $customers = Employee::with('roles')
                ->where('is_manager', true)
                ->whereNull('manager_id')
                ->withoutGlobalScope(ParentScope::class)->get();
            return response()->json($customers);
        }
        return view('dashboard.customers.index');
    }

    public function create()
    {

        $this->authorize('create_users');
        $roles = Role::whereIn('id', [1,2])->get();
        return view('dashboard.customers.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $this->authorize('create_users');
        $rules = Employee::$managerRules;
        $customer = Employee::create($request->validate($rules));
        $role = Role::find($request->validate(['role_id' => 'required|numeric|exists:roles,id']));
        $customer->assignRole($role);
        $customer->is_manager = true;
        if($role->label == "User"){
            $customer->generateDefaultRoles();
        }
        $jobNumber = rand(1000,9999);
        while (Employee::pluck('job_number')->contains($jobNumber)){
            $jobNumber = rand(1000,9999);
        }
        $customer->job_number = $jobNumber;
        $customer->save();
        return redirect(route('dashboard.customers.index'));
    }

    public function edit($id)
    {
        $this->authorize('update_users');
        $customer = Employee::withoutGlobalScope(ParentScope::class)->find($id);
        $roles = Role::whereIn('id', [1,2])->get();
        return view('dashboard.customers.edit', compact('customer', 'roles'));
    }

    public function update($id, Request $request)
    {
        $this->authorize('update_users');
        $customer = Employee::withoutGlobalScope(ParentScope::class)->find($id);
        $rules = Employee::$managerRules;
        $rules['email'] = ($rules['email'] . ',email,' . $customer->id);
        $customer->update($request->validate($rules));
        $role = Role::find($request->validate(['role_id' => 'required|numeric|exists:roles,id']));
        $customer->roles()->detach($customer->roles);
        $customer->assignRole($role);
        return redirect(route('dashboard.customers.index'));
    }

    public function destroy($id, Request $request)
    {
        $this->authorize('delete_users');
        if($request->ajax()){
            $customer = Employee::withoutGlobalScope(ParentScope::class)->find($id);
            $customer->delete();
            return response()->json([
                'status' => true,
                'message' => 'Item Deleted Successfully'
            ]);
        }
        return redirect(route('dashboard.customers.index'));
    }
}
