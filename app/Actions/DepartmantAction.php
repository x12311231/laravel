<?php

namespace App\Actions;

use App\DTOs\DepartmentData;
use App\Models\Department;

class DepartmantAction
{
    public function execute(DepartmentData $departmentData): Department
    {
        return Department::create([
            'name' => $departmentData->name,
            'description' => $departmentData->description,
        ]);
    }
}
