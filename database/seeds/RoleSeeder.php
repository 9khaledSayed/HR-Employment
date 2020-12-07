<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    protected $managerId;
    public function __construct($managerId = 1)
    {
        $this->managerId= $managerId;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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

        foreach ($categories as $category) {
            \App\Ability::create([
                'name'  => 'view_' . $category,
                'label' => 'View ' . ucfirst($category),
                'category' => $category
            ]);
            \App\Ability::create([
                'name'  => 'show_' . $category,
                'label' => 'Show ' . ucfirst($category),
                'category' => $category
            ]);
            \App\Ability::create([
                'name'  => 'create_' . $category,
                'label' => 'Create ' . ucfirst($category),
                'category' => $category
            ]);
            \App\Ability::create([
                'name'  => 'update_' . $category,
                'label' => 'Update ' . ucfirst($category),
                'category' => $category
            ]);
            \App\Ability::create([
                'name'  => 'delete_' . $category,
                'label' => 'Delete ' . ucfirst($category),
                'category' => $category
            ]);

        }
        if ($this->managerId == 1){
            $superAdmin = \App\Role::create([
                'name_english'  => 'Super Admin',
                'name_arabic'  => 'المدير التنفيذي',
                'label' => 'Super Admin',
                'type' => 'System Role',
                'manager_id' => $this->managerId
            ]);
            $user = \App\Role::create([
                'name_english'  => 'User',
                'name_arabic'  => 'عميل',
                'label' => 'User',
                'type' => 'System Role',
                'manager_id' => $this->managerId
            ]);
        }
        $Hr = \App\Role::create([
            'name_english'  => 'HR',
            'name_arabic'  => 'مدير الموارد البشرية',
            'label' => 'HR',
            'type' => 'System Role',
            'manager_id' => $this->managerId
        ]);
        $supervisor = \App\Role::create([
            'name_english'  => 'Supervisor',
            'name_arabic'  => 'المدير المباشر',
            'label' => 'Supervisor',
            'type' => 'System Role',
            'manager_id' => $this->managerId
        ]);
        $employee = \App\Role::create([
            'name_english'  => 'Employee',
            'name_arabic'  => 'موظف',
            'label' => 'Employee',
            'type' => 'System Role',
            'manager_id' => $this->managerId
        ]);
        $abilities = \App\Ability::get();
        foreach($abilities as $ability){
            $superAdmin->allowTo($ability);
        }

        foreach($abilities->whereIn('category',['employees', 'employees_violations', 'reports', 'conversations']) as $ability){
            $user->allowTo($ability);
        }

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
