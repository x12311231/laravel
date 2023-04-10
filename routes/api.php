<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeePaycheckController;
use App\Http\Controllers\PaydayController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Spatie\QueryBuilder\QueryBuilder;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//Route::get('posts/{post}', function (Request $request, Post $post) {
//    return new PostResource($post->load(['author', 'comments']));
//});

//Route::get('posts/{post}', fn(Post $post) => PostResource::make($post));

//Route::resource('posts', PostResource::class);

Route::get('posts/{id}', function (Request $request, int $id) {
    return QueryBuilder::for(Post::where('id', $id))
        ->allowedFields(['id', 'title', 'slug', 'content', 'views', 'created_at', 'updated_at'])
        ->get();
});

Route::get('posts', function (Request $request) {
    $posts = QueryBuilder::for(Post::class)
        ->allowedFields(['id', 'title', 'content', 'views', 'created_at', 'authors.id', 'authors.name'])
        ->allowedFilters(['title'])
        ->defaultSort('-id')
        ->allowedSorts(['views', 'created_at'])
        ->allowedIncludes('author')
//        ->get();
        ->paginate(10);
    return PostResource::collection($posts);
})->name('postsss');

Route::apiResource('departments', DepartmentController::class);

Route::apiResource('employees', \App\Http\Controllers\EmployeeController::class);

Route::get('department/{department}/employees', function (\App\Models\Department $department) {
    $employees = QueryBuilder::for(\App\Models\Employee::class)
        ->whereBelongsTo($department)
        ->allowedFilters(['full_name'])
        ->paginate(10);
    return \App\Http\Resources\EmployeeResource::collection($employees);
})->name('department.employees.index');

Route::post(
    'paycheck',
    [PaydayController::class, 'store']
)->name('payday.store');

Route::get(
    'employees/{employee}/paychecks',
    [EmployeePaycheckController::class, 'index']
)->name('employee.paychecks.index');
