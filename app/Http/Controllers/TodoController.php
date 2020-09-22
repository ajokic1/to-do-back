<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodo;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Todo::class, 'todo');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return auth()->user()->todos()->orderBy('priority', 'DESC')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTodo $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTodo $request)
    {
        $todo = Todo::make($request->validated());
        auth()->user()->todos()->save($todo);

        return response()->json([
            "data" => $todo
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        return response($todo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreTodo $request
     * @param \App\Models\Todo $todo
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreTodo $request, Todo $todo)
    {
        $todo->update($request->validated());

        return response()->json([
            "data" => $todo
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();

        return response("Successfully deleted todo with id {$todo->id}.");
    }
}
