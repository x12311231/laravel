<?php

use App\Models\Department;

use function Pest\Laravel\getJson;

it('should return a department', function () {
    $development = Department::factory(['name' => 'Development'])->create();

    $department = getJson($uri = route('departments.show', ['department' => $development]))
    ->json('data');

    expect($department)
//        ->attributes->name->toBe('Development');
        ->toMatchArray([
            'name' => 'Development',
        ]);
});

it('should return all departments', function () {
    $names = ['Development', 'Market', 'Administration'];
    foreach ($names as $name) {
        Department::factory(['name' => 'Development'])->create();
    }

    $departments = getJson($uri = route('departments.index'))->json('data');

//    expect($departments)->toHaveCount(3);
});
