<?php

use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\postJson;

it('should return 422 if email is invalid', function (?string $email) {
    Sanctum::actingAs(User::factory()->create(), ['*']);

    Employee::factory([
        'email' => 'taken@example.com',
    ])->create();

    $uri = route('employees.store');
    $data = [
        'full_name' => 'Test Employee',
        'email' => $email,
        'department_id' => Department::factory()->create()->id,
        'job_title' => 'BE Developer',
        'payment_type' => 'salary',
        'salary' => 75000 * 100,
//        'hourly_rate' => 0,
    ];
    $jdata = json_encode($data);
    postJson($uri, $data)->assertInvalid(['email']);
})->with([
    'taken@example.com',
    'invalid',
    null,
    '',
]);
//
it('should return 422 if payment type is invalid', function () {
    Sanctum::actingAs(User::factory()->create(), ['*']);

    Employee::where(['email' => 'test@example.com'])
        ->delete();


    $data = [
        'fullName' => 'Test Employee',
        'email' => 'test@example.com',
        'departmentId' => Department::factory()->create()->id,
        'jobTitle' => 'BE Developer',
        'paymentType' => 'salary',
        'salary' => 75000 * 100,
    ];
    $data1 = [];
    foreach ($data as $k => $v) {
        $data1[\Illuminate\Support\Str::snake($k)] = $v;
    }
    $jdata1 = json_encode($data1);
    postJson(route('employees.store'), $data1)->isOk();
    Employee::where(['email' => 'test@example.com'])
        ->delete();
    $data = [
        'fullName' => 'Test Employee',
        'email' => 'test@example.com',
        'departmentId' => Department::factory()->create()->id,
        'jobTitle' => 'BE Developer',
        'paymentType' => 'salary',
        'salary' => 75000 * 100,
        'hourly_rate' => "a",
    ];
    $data1 = [];
    foreach ($data as $k => $v) {
        $data1[\Illuminate\Support\Str::snake($k)] = $v;
    }
    $jdata1 = json_encode($data1);
    postJson(route('employees.store'), $data1)->assertInvalid(['hourly_rate']);
    Employee::where(['email' => 'test@example.com'])
        ->delete();
    $data = [
        'fullName' => 'Test Employee',
        'email' => 'test@example.com',
        'departmentId' => Department::factory()->create()->id,
        'jobTitle' => 'BE Developer',
        'paymentType' => 'invalid',
        'salary' => 75000 * 100,
//        'hourly_rate' => 0,
    ];
    $data1 = [];
    foreach ($data as $k => $v) {
        $data1[\Illuminate\Support\Str::snake($k)] = $v;
    }
    $jdata1 = json_encode($data1);
    postJson(route('employees.store'), $data1)->assertInvalid(['payment_type']);
});
it('should return 422 if salary missing when payment type is salary1', function (string $paymentType, $salary) {
    Sanctum::actingAs(User::factory()->create(), ['*']);

    Employee::where(['email' => 'test@example.com'])
        ->delete();
    $data = [
        'fullName' => 'Test Employee',
        'email' => 'test@example.com',
        'departmentId' => Department::factory()->create()->id,
        'jobTitle' => 'BE Developer',
        'paymentType' => $paymentType,
        'salary' => $salary,
    ];
    $data1 = [];
    foreach ($data as $k => $v) {
        $data1[\Illuminate\Support\Str::snake($k)] = $v;
    }
    $testResponse = postJson(route('employees.store'), $data1)->json('data');
    echo 1;
    expect($testResponse)->toBeArray();
})->with([
    ['paymentType' => 'salary', 'salary' => 0.1],
    ['paymentType' => 'salary', 'salary' => 0.01],
]);
//
it('should return 422 if salary missing when payment type is salary', function (string $paymentType, $salary) {
    Sanctum::actingAs(User::factory()->create(), ['*']);

    Employee::where(['email' => 'test@example.com'])->delete();
    $data = [
        'fullName' => 'Test Employee',
        'email' => 'test@example.com',
        'departmentId' => Department::factory()->create()->id,
        'jobTitle' => 'BE Developer',
        'paymentType' => $paymentType,
        'salary' => $salary,
    ];
    $data1 = [];
    foreach ($data as $k => $v) {
        $data1[\Illuminate\Support\Str::snake($k)] = $v;
    }
    postJson(route('employees.store'), $data1)->assertInvalid(['salary']);
})->with([
    ['payment_type' => 'salary', 'salary' => "a"],
    ['paymentType' => 'salary', 'salary' => null],
    ['paymentType' => 'salary', 'salary' => -1],
    ['paymentType' => 'salary', 'salary' => 0],
    ['paymentType' => 'hourly_rate', 'salary' => 0],
]);
it('should return 422 if salary missing when payment type is hourly_rate', function (string $paymentType, $salary) {
    Sanctum::actingAs(User::factory()->create(), ['*']);

    Employee::where(['email' => 'test@example.com'])
        ->delete();
    $data = [
        'fullName' => 'Test Employee',
        'email' => 'test@example.com',
        'departmentId' => Department::factory()->create()->id,
        'jobTitle' => 'BE Developer',
        'paymentType' => $paymentType,
        'hourly_rate' => $salary,
    ];
    $data1 = [];
    foreach ($data as $k => $v) {
        $data1[\Illuminate\Support\Str::snake($k)] = $v;
    }
    postJson(route('employees.store'), $data1)->assertInvalid(['hourly_rate']);
})->with([
    ['paymentType' => 'hourly_rate', 'salary' => 0],
    ['paymentType' => 'hourly_rate', 'salary' => -1],
    ['paymentType' => 'hourly_rate', 'salary' => null],
]);
//
it('should return 422 if hourly rate missing when payment type is hourly rate', function (string $paymentType, ?int $hourlyRate) {
    Sanctum::actingAs(User::factory()->create(), ['*']);

    Employee::where(['email' => 'test@example.com'])->delete();
    $arr = [
        'fullName' => 'Test Employee',
        'email' => 'test@example.com',
        'departmentId' => Department::factory()->create()->id,
        'jobTitle' => 'BE Developer',
        'paymentType' => $paymentType,
        'hourlyRate' => $hourlyRate,
    ];
    $arr1 = [];
    foreach ($arr as $k => $v) {
        $arr1[\Illuminate\Support\Str::snake($k)] = $v;
    }
    postJson(route('employees.store'), $arr1)->assertInvalid(['hourly_rate']);
})->with([
    ['paymentType' => 'hourlyRate', 'hourlyRate' => null],
    ['paymentType' => 'hourlyRate', 'hourlyRate' => 0],
]);

it('should return is expected', function (string $paymentType, ?int $hourlyRate) {
    Sanctum::actingAs(User::factory()->create(), ['*']);

    Employee::where(['email' => 'test@example.com'])->delete();
    $arr = [
        'fullName' => 'Test Employee',
        'email' => 'test@example.com',
        'departmentId' => Department::factory()->create()->id,
        'jobTitle' => 'BE Developer',
        'paymentType' => $paymentType,
        'hourlyRate' => $hourlyRate,
    ];
    $arr1 = [];
    foreach ($arr as $k => $v) {
        $arr1[\Illuminate\Support\Str::snake($k)] = $v;
    }
    $testResponse = postJson(route('employees.store'), $arr1)->json('data');
    echo 1;
    expect((int)$testResponse["id"])->toBeInt();
})->with([
    ['paymentType' => 'hourly_rate', 'hourlyRate' => 100],
    ['paymentType' => 'hourly_rate', 'hourlyRate' => 1],
]);
