<?php

namespace App\Http\Controllers\Dashboard;

use App\Employee;
use App\Http\Controllers\Controller;
use App\Role;
use App\Rules\UniqueJopNumber;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $this->authorize('view_employees');
        if ($request->ajax()){
            $employees = Employee::with('roles')->get();
            return response()->json($employees);
        }
        return view('dashboard.employees.index');
    }

    public function create()
    {
        $this->authorize('create_employees');
        $roles = Role::get();
        return view('dashboard.employees.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $this->authorize('create_employees');
        $rules = Employee::$rules;
        array_push($rules['job_number'], new UniqueJopNumber());
        $employee = Employee::create($request->validate($rules));
        $role = Role::find($request->validate(['role_id' => 'required|numeric|exists:roles,id']));
        $employee->assignRole($role);
        return redirect(route('dashboard.employees.index'));
    }

    public function edit(Employee $employee)
    {
        $this->authorize('update_employees');
        $roles = Role::get();
        return view('dashboard.employees.edit', compact('employee', 'roles'));
    }

    public function update(Employee $employee, Request $request)
    {
        $this->authorize('update_employees');
        $rules = Employee::$rules;
        $rules['email'] = ($rules['email'] . ',email,' . $employee->id);
        array_push($rules['job_number'], new UniqueJopNumber($employee->id));
        $employee->update($request->validate($rules));
        $role = Role::find($request->validate(['role_id' => 'required|numeric|exists:roles,id']));
        $employee->roles()->detach($employee->roles);
        $employee->assignRole($role);
        return redirect(route('dashboard.employees.index'));
    }

    public function destroy(Employee $employee, Request $request)
    {
        $this->authorize('delete_employees');
        if($request->ajax()){
            $employee->delete();
            return response()->json([
                'status' => true,
                'message' => 'Item Deleted Successfully'
            ]);
        }
        return redirect(route('dashboard.employees.index'));
    }
}
