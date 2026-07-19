<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $allowedFields = ['id', 'title', 'content', 'created_at', 'updated_at'];

        $fields = array_intersect(
            explode(',', $request->query('fields', '')),
            $allowedFields
        );

        $tasks = Task::get(empty($fields) ? ['*'] : $fields);

        return response()->json($tasks, 200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $task = Task::create($request->validated());

        return response()->json($task, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return response()->json([
            'success' => true,
            'data' => $task,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        return response()->json($task, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'message' => 'Tarefa deletada com sucesso!',
        ], 200);
    }
}
