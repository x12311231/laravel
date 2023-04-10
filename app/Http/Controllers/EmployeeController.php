<?php

namespace App\Http\Controllers;

use App\Actions\UpsertEmployeeAction;
use App\DTOs\EmployeeData;
use App\Http\Requests\UpsertEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function __construct(
        public UpsertEmployeeAction $upsertEmployeeAction,
        public Employee $employee,
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
     * @throws \ReflectionException
     */
    public function store(UpsertEmployeeRequest $request)
    {
        $employee = $this->upsertEmployeeAction->execute($this->employee, new EmployeeData(...$request->validated()));
        return EmployeeResource::make($employee)->response();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
