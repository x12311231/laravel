<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(
        public Request $request,
    )
    {
    }

    public function show($id)
    {
        $data = $this->request->validate(['userId' => 'required|integer']);
        return ['post' => $id, 'data' => $data];
    }
}
