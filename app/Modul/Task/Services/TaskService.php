<?php

namespace App\Modul\Task\Services;

use App\Modul\Task\Model\Task;
use App\Modul\Task\Model\TaskActivity;
use Illuminate\Support\Facades\DB;

class TaskService
{
    public function updateStatus(Task $task, string $status, $userId)
    {
        return DB::transaction(function () use ($task, $status, $userId) {
            $oldStatus = $task->status;
            $task->update([
                'status' => $status,
                'started_at' => ($status === 'in_progress' && !$task->started_at) ? now() : $task->started_at,
                'completed_at' => ($status === 'done') ? now() : null,
            ]);

            TaskActivity::create([
                'task_id' => $task->id,
                'user_id' => $userId,
                'action' => 'status_change',
                'details' => "Changed status from $oldStatus to $status",
                'changes' => json_encode(['from' => $oldStatus, 'to' => $status])
            ]);
            
            // Check for Auto-KB generation if Done
            if ($status === 'done') {
                // Event::dispatch(new TaskCompleted($task));
            }

            return $task; 
        });
    }
}
