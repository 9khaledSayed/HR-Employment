<?php

namespace App\Http\Controllers\Dashboard;

use App\Employee;
use App\EmployeeViolation;
use App\Http\Controllers\Controller;
use App\Rules\NotRepeated;
use App\Violation;
use Illuminate\Http\Request;

class EmployeeViolationController extends Controller
{

    public function index(Request $request)
    {
        $this->authorize('view_employees_violations');
        if ($request->ajax()){
            $employees_violations = EmployeeViolation::with(['employee', 'violation'])->get();
            return response()->json($employees_violations);
        }
        return view('dashboard.employees_violations.index');
    }


    public function create()
    {
        $this->authorize('create_employees_violations');
        $employees = Employee::get();
        $violations = Violation::get();
        return view('dashboard.employees_violations.create', compact('employees', 'violations'));
    }


    public function store(Request $request)
    {

        $this->authorize('create_employees_violations');
        $rules = EmployeeViolation::$rules;
        array_push($rules['employee_id'], new NotRepeated($request));
        $rules['date'] = $rules['date'] . Date('Y-m-d');
        $employeeViolation = EmployeeViolation::create($request->validate($rules));
        return redirect(route('dashboard.employees_violations.show', $employeeViolation));
    }


    public function show($id)
    {
        $employeeViolation = EmployeeViolation::find($id);
        abort_if(!isset($employeeViolation), 404);
        $employee = $employeeViolation->employee;
        $violation = $employeeViolation->violation;
        $panels = Violation::find($violation->id,['panel1','panel2', 'panel3', 'panel4'])->toArray();
        $lastPanelExist = array_key_last(array_filter($panels));
        $dailySalary = $employee->dailySalary();
        $besideDeduction = 0;
        $repeats = $employeeViolation->repeats;
        if( $repeats < 4 && isset($violation->{'panel' . $repeats})){
            $deduction = $this->calculateDeduction($dailySalary, $violation->{'panel' . $repeats});
        }else{
            $deduction = $this->calculateDeduction($dailySalary, $violation->{$lastPanelExist});
        }

        if($violation->addition_to == "minutes_deduc") // minutes late deduction
            $additionTo = $employeeViolation->minutes_late * ($dailySalary/(8*60));
        else // absence days deductions
            $additionTo = $employeeViolation->absence_days * $dailySalary;

        return view('dashboard.employees_violations.show', [
            'deduction' => $deduction,
            'besideDeduction' => number_format($additionTo, 2) . __(' S.R'),
            'employeeViolation' => $employeeViolation,
            'addition_to_description' => __($violation->addition_to)
        ]);
    }


    public function edit($id)
    {
        $this->authorize('update_employees_violations');
        $employeeViolation = EmployeeViolation::find($id);
        $employees = Employee::get();
        $violations = Violation::get();
        return view('dashboard.employees_violations.edit', compact('employees', 'violations', 'employeeViolation'));
    }


    public function update(Request $request, $id)
    {
        $this->authorize('update_employees_violations');
        $employeeViolation = EmployeeViolation::find($id);
        $rules = EmployeeViolation::$rules;
        array_push($rules['employee_id'], new NotRepeated($request, $employeeViolation));
        $rules['date'] = $rules['date'] . Date('Y-m-d');
        $employeeViolation->update($request->validate($rules));
        return redirect(route('dashboard.employees_violations.index'));
    }


    public function destroy(Request $request,$id)
    {
        $this->authorize('delete_employees_violations');
        if($request->ajax()){
            EmployeeViolation::find($id)->delete();
            return response()->json([
                'status' => true,
                'message' => 'Item Deleted Successfully'
            ]);
        }
        return redirect(route('dashboard.employees_violations.index'));
    }
    public function calculateDeduction($dailySalary, $panelValue)
    {
        if (@number_format($panelValue) != null)
            return number_format($dailySalary * ($panelValue/100), 2) . __(' S.R');
        return $panelValue;;
    }
}
