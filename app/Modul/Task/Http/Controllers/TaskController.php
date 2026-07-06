<?php

namespace App\Modul\Task\Http\Controllers;

use App\Http\Controllers\Admin\AdminController;
use App\Modul\Task\Model\Task;
use Illuminate\Http\Request;

class TaskController extends AdminController
{
    public function index(Request $request)
    {
        $query = Task::with(['assignee', 'creator', 'subtasks.subtasks'])
                     ->whereNull('parent_task_id'); // Only show top-level tasks
        
        
        // Basic Filters mimicking "Smart Lists"
        if ($request->input('filter') === 'important') {
            $query->whereIn('priority', ['high', 'urgent']);
        } elseif ($request->input('filter') === 'planned') {
            $query->whereNotNull('due_at');
        } elseif ($request->input('filter') === 'assigned') {
            $query->where('assigned_to', auth()->id());
        } else {
            // Default "My Day" / All incomplete or recently completed
            // Showing all for now to be simple
        }

        $tasks = $query->latest()->get();
        // Sort by status priority in PHP to avoid SQL incompatibility (e.g. SQLite doesn't have FIELD())
        $statusOrder = ['pending' => 1, 'in_progress' => 0, 'blocked' => 2, 'done' => 3];
        $tasks = $tasks->sortBy([
            fn($a, $b) => ($statusOrder[$a->status] ?? 99) <=> ($statusOrder[$b->status] ?? 99),
            fn($a, $b) => $b->created_at <=> $a->created_at
        ]);
        
        return view('task::index', [
            'judul' => 'Task Management',
            'tasks' => $tasks
        ]);
    }

    public function show($uuid)
    {
        $task = Task::where('uuid', $uuid)->with(['creator', 'assignee', 'activities', 'subtasks'])->firstOrFail();
        return view('task::detail', ['task' => $task]);
    }
}
