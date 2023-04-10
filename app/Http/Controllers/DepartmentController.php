<?php

namespace App\Http\Controllers;

use App\Actions\DepartmantAction;
use App\Actions\UpdateDepartmentAction;
use App\DTOs\DepartmentData;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class DepartmentController extends Controller
{
//    private $createDepartment;

    public function __construct(
        public readonly DepartmantAction $createDepartmentAction,
        public readonly UpdateDepartmentAction $updateDepartmentAction,
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return DepartmentResource::collection(Department::paginate());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
        $departmentData = new DepartmentData(...$request->validated());
        $department = $this->createDepartmentAction->execute($departmentData);

        return DepartmentResource::make($department)
            ->response();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return DepartmentResource::make(Department::where(['uuid' => $id])->first());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $departmentData = new DepartmentData(...$request->validated());
//        $this->updateDepartmentAction->execute(Department::where(['uuid' => $id])->first(), $departmentData);
        $this->updateDepartmentAction->execute($department, $departmentData);
        return \response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
