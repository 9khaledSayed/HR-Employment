<?php

namespace App;

use App\Scopes\ParentScope;
use Illuminate\Database\Eloquent\Model;

class EmployeeViolation extends Model
{
    protected $guarded = [];
    protected $dates = ['date'];
    protected $casts = [
        'created_at'  => 'date:D M d Y',
        'date'  => 'date:D M d Y',
    ];
    public static $rules = [
        'employee_id' => ['required','numeric','exists:employees,id'],
        'violation_id' => 'required|numeric|exists:violations,id',
        'date' => 'required|date|before_or_equal:',
        'minutes_late' => 'nullable|numeric',
        'absences_days' => 'nullable|numeric',
    ];

    public static function booted()
    {
        static::creating(static function ($model){
            $repeats = EmployeeViolation::where('employee_id',$model->employee_id)
                ->where('violation_id',$model->violation_id)
                ->count();
            $employee = auth()->user();
            $manager_id = ($employee->is_manager)? $employee->id:$employee->manager->id;
            $model->manager_id = $manager_id;
            $model->repeats = $repeats + 1;
        });
        static::addGlobalScope(new ParentScope());
    }


    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function violation()
    {
        return $this->belongsTo(Violation::class);
    }
}
