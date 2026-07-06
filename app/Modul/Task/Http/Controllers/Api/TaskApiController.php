<?php

namespace App\Modul\Task\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modul\Task\Model\Task;
use App\Modul\Task\Services\TaskService;
use App\Modul\Task\Services\AiTaskGenerator;
use Illuminate\Http\Request;

class TaskApiController extends Controller
{
    protected $taskService;
    protected $aiGenerator;

    public function __construct(TaskService $taskService, AiTaskGenerator $aiGenerator)
    {
        $this->taskService = $taskService;
        $this->aiGenerator = $aiGenerator;
    }

    public function index(Request $request)
    {
        $query = Task::query();
        
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        if ($request->has('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }
        
        return response()->json($query->paginate(20));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'priority' => 'required|in:low,medium,high,urgent',
                'tiket_id' => 'nullable|exists:tikets,id',
                'parent_task_id' => 'nullable|exists:tasks,id'
            ]);

            $task = Task::create(array_merge($validated, [
                'uuid' => (string) \Illuminate\Support\Str::uuid(),
                'created_by' => auth()->id(),
                'status' => 'pending',
                'parent_task_id' => $request->parent_task_id ?? null
            ]));

            return response()->json($task, 201);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Task Store Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($uuid)
    {
        $task = Task::where('uuid', $uuid)->with('activities')->firstOrFail();
        return response()->json($task);
    }

    public function update(Request $request, $uuid)
    {
        $task = Task::where('uuid', $uuid)->firstOrFail();
        $data = $request->only('title', 'description');
        if($request->has('due_at')) {
             $data['due_at'] = $request->due_at ?: null;
        }
        $task->update($data); 
        return response()->json($task);
    }
    
    public function updateStatus(Request $request, $uuid)
    {
        $request->validate(['status' => 'required']);
        $task = Task::where('uuid', $uuid)->firstOrFail();
        
        $task = $this->taskService->updateStatus($task, $request->status, auth()->id());
        
        return response()->json($task);
    }

    public function assign(Request $request, $uuid)
    {
         $request->validate(['assigned_to' => 'required|exists:pengguna,id']);
         $task = Task::where('uuid', $uuid)->firstOrFail();
         $task->update(['assigned_to' => $request->assigned_to]);
         
         return response()->json($task);
    }

    public function destroy($uuid)
    {
         $task = Task::where('uuid', $uuid)->firstOrFail();
         $task->delete();
         return response()->json(['message' => 'Task deleted']);
    }
    
    public function generateFromAi(Request $request)
    {
         // Implementation for manual triggering, e.g. passing a string
         $content = $request->input('content');
         $tasks = $this->aiGenerator->analyzeAndProposeTasks($content, 'manual', auth()->id());
         return response()->json(['data' => $tasks]);
    }
}
