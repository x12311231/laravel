<?php

namespace App\Actions;

use App\DTOs\EmployeeData;
use App\Models\Employee;
use Illuminate\Support\Str;

class UpsertEmployeeAction
{
    /**
     * @throws \ReflectionException
     */
    public function execute(Employee $employee, EmployeeData $employeeData)
    {
        $reflectClass = new \ReflectionClass($employeeData);
        foreach ($reflectClass->getProperties() as $k => $v) {
            $name = $v->name;
            $employee->setAttribute($v->name, $employeeData->{$name});
        }
//        foreach ($reflectClass->getProperties() as $k => $v) {
//            $method = Str::camel('get_' . $v->name);
//            $value = call_user_func_array([$employeeData, $method], []);
//            $employee->setAttribute($v->name, $value);
//        }
//        Str::snake()
//        $employee->full_name = $employeeData->getFullName();
//        $employee->email = $employeeData->getEmail();
//        $employee->department_id = $employeeData->getDepartmentId();
//        $employee->job_title = $employeeData->getJobTitle();
//        $employee->payment_type = $employeeData->getPaymentType();
//        $employee->salary = $employeeData->getSalary();
//        $employee->hourly_rate = $employeeData->getHourlyRate();

//        $employee->full_name = $employeeData->full_name;
//        $employee->email = $employeeData->email;
//        $employee->department_id = $employeeData->department_id;
//        $employee->job_title = $employeeData->job_title;
//        $employee->payment_type = $employeeData->payment_type;
//        $employee->salary = $employeeData->salary;
//        $employee->hourly_rate = $employeeData->hourly_rate;
        $employee->save();
        return $employee;
    }
}
