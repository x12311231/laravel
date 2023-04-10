<?php

use App\Models\Department;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\putJson;

it('should update a department', function (string $name, string $description) {
    Sanctum::actingAs(User::factory()->create(), ['*']);

    // 先新建
    $department = Department::factory([
        'name' => 'Development',
    ])->create();

    // 再调用更新 API 接口
    $res = putJson($uri = route('departments.update', compact('department')), [
        'name' => $name,
        'description' => $description,
    ]);
    $res->assertNoContent();

    // 断言响应数据
    $d = Department::find($department->id);
    expect($d)
        ->toMatchArray([
            'name' => $name,
            'description' => $description
        ]);

})->with([
    ['name' => 'Development', 'description' => 'Updated Description'],
    ['name' => 'Development New', 'description' => 'Updated Description'],
]);
