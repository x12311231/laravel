<?php

namespace App\DTOs;

use phpDocumentor\Reflection\Types\Scalar;

class EmployeeData
{

    public function __construct(
        public readonly string $full_name,
        public readonly string $email,
        public readonly int $department_id,
        public readonly string $job_title,
        public readonly string $payment_type,
        public readonly ?float $salary = null,
        public readonly ?float $hourly_rate = null,
    )
    {
    }
//    protected $full_name;
//
//    protected $email;
//
//    protected $department_id;
//
//    protected $job_title;
//
//    protected $payment_type;
//
//    protected $salary;
//
//    protected $hourly_rate;
//
//
//    /**
//     * @param $full_name
//     * @param $email
//     * @param $department_id
//     * @param $job_title
//     * @param $payment_type
//     * @param $salary
//     * @param $hourly_rate
//     */
//    public function __construct($full_name, $email, $department_id, $job_title, $payment_type, $salary, $hourly_rate = null)
//    {
//        $this->full_name = $full_name;
//        $this->email = $email;
//        $this->department_id = $department_id;
//        $this->job_title = $job_title;
//        $this->payment_type = $payment_type;
//        $this->salary = $salary;
//        $this->hourly_rate = $hourly_rate;
//    }
//    /**
//     * @return mixed
//     */
//    public function getFullName(): mixed
//    {
//        return $this->full_name;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getEmail()
//    {
//        return $this->email;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getDepartmentId()
//    {
//        return $this->department_id;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getJobTitle()
//    {
//        return $this->job_title;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getPaymentType()
//    {
//        return $this->payment_type;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getSalary()
//    {
//        return $this->salary;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getHourlyRate()
//    {
//        return $this->hourly_rate;
//    }

}
