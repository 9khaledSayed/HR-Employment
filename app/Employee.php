<?php

namespace App;

use App\Rules\UniqueJopNumber;
use App\Scopes\ParentScope;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Employee extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    protected $table = 'employees';

    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public static $rules = [
        'name_in_arabic' => 'required|string|max:191',
        'name_in_english' => 'required|string|max:191',
        'email' => 'sometimes|required|email|unique:employees',
        'salary' => 'required|numeric',
        'job_number' => ['required'],
        'password' => ['required', 'string', 'min:8', 'confirmed']
    ];
    public static $managerRules = [
        'name_in_arabic' => 'required|string|max:191',
        'name_in_english' => 'required|string|max:191',
        'email' => 'sometimes|required|email:dns|unique:employees',
        'password' => ['required', 'string', 'min:8', 'confirmed']
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at'  => 'date:D M d Y',
    ];
    public static function booted()
    {

        static::addGlobalScope(new ParentScope());

        static::creating(function ($model){
             if(auth()->check()){
                 $employee = auth()->user();
                 $manager_id = ($employee->is_manager)? $employee->id:$employee->manager->id;
                 $model->manager_id = $manager_id;
             }
         });
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function name()
    {
        return app()->isLocale('ar')? $this->name_in_arabic: $this->name_in_english;
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withoutGlobalScope(ParentScope::class)->withTimestamps();
    }

    public function assignRole($role)
    {
        if(is_string($role)){
            $role = Role::where('label', $role)->firstOrFail();
        }
        return $this->roles()->sync($role, false);
    }

    public function abilities()
    {
        return $this->roles->map->abilities->flatten()->pluck('name')->unique();
    }

    public function manager()
    {
        return $this->belongsTo(Employee::class, 'manager_id')->withoutGlobalScope(ParentScope::class);
    }

    public function dailySalary()
    {
        return $this->salary / 30;
    }

    public function generateDefaultRoles()
    {
        $categories = [
            'roles',
            'users',
            'violations',
            'employees',
            'employees_violations',
            'reports',
            'conversations',
        ];
        $abilities = \App\Ability::get();
        if ($this->id == 1){
            $superAdmin = \App\Role::create([
                'name_english'  => 'Super Admin',
                'name_arabic'  => 'المدير التنفيذي',
                'label' => 'Super Admin',
                'type' => 'System Role',
                'manager_id' => $this->id
            ]);
            $user = \App\Role::create([
                'name_english'  => 'User',
                'name_arabic'  => 'عميل',
                'label' => 'User',
                'type' => 'System Role',
                'manager_id' => $this->id
            ]);

            foreach($abilities as $ability){
                $superAdmin->allowTo($ability);
            }

            foreach($abilities->whereIn('category',['employees', 'employees_violations', 'reports', 'conversations']) as $ability){
                $user->allowTo($ability);
            }
        }
        $Hr = \App\Role::create([
            'name_english'  => 'HR',
            'name_arabic'  => 'مدير الموارد البشرية',
            'label' => 'HR',
            'type' => 'System Role',
            'manager_id' => $this->id
        ]);
        $supervisor = \App\Role::create([
            'name_english'  => 'Supervisor',
            'name_arabic'  => 'المدير المباشر',
            'label' => 'Supervisor',
            'type' => 'System Role',
            'manager_id' => $this->id
        ]);
        $employee = \App\Role::create([
            'name_english'  => 'Employee',
            'name_arabic'  => 'موظف',
            'label' => 'Employee',
            'type' => 'System Role',
            'manager_id' => $this->id
        ]);


        foreach($abilities->whereIn('category',['employees', 'employees_violations', 'reports', 'conversations']) as $ability){
            $Hr->allowTo($ability);
        }

        foreach($abilities->whereIn('category',['reports']) as $ability){
            $supervisor->allowTo($ability);
        }

        foreach($abilities->whereIn('category',['conversations']) as $ability){
            $employee->allowTo($ability);
        }
    }

}
