@props(['task', 'level' => 0])

<div class="todo-item {{ $task->status == 'done' ? 'completed' : '' }}" 
     style="margin-left: {{ $level * 40 }}px; 
            border-bottom: 1px solid #f8fafc; 
            background: {{ $level > 0 ? '#fafafa' : '#fff' }};">
    
    <div class="todo-checkbox {{ $task->status == 'done' ? 'checked' : '' }}" 
         onclick="event.stopPropagation(); toggleStatus('{{ $task->uuid }}', '{{ $task->status == 'done' ? 'pending' : 'done' }}')">
        <i class="fas fa-check"></i>
    </div>
    
    <div class="todo-content" onclick="window.location.href='/admin/task/{{ $task->uuid }}'">
        <div class="todo-title" style="font-size: {{ $level > 0 ? '0.95rem' : '1rem' }};">{{ $task->title }}</div>
        <div class="todo-meta">
            @if($task->priority == 'urgent' || $task->priority == 'high')
                <span class="priority-indicator priority-{{ $task->priority }}">
                    {{ $task->priority }}
                </span>
            @endif
            
            @if($task->due_at)
                <span style="color: {{ $task->due_at < now() && $task->status != 'done' ? '#ef4444' : 'inherit' }}">
                    <i class="far fa-clock"></i> {{ $task->due_at->format('M d') }}
                </span>
            @endif
        </div>
    </div>

    <div class="todo-actions">
         @if($level == 0)
             @if($task->priority == 'high' || $task->priority == 'urgent')
                <i class="fas fa-star" style="color: #f59e0b; cursor: pointer;"></i>
             @else
                <i class="far fa-star" style="color: #cbd5e1; cursor: pointer;"></i>
             @endif
         @endif
         <!-- Allow adding subtask to ANY level -->
         <i class="fas fa-plus" title="Add Subtask" style="color: #64748b; cursor: pointer;" onclick="event.stopPropagation(); toggleSubtaskForm('{{ $task->uuid }}')"></i>
    </div>
</div>

<!-- Inline Subtask Form for THIS task -->
<div id="subtask-form-{{ $task->uuid }}" style="display:none; margin-left: {{ ($level + 1) * 40 }}px; padding: 10px; border-bottom: 1px solid #f1f5f9; background: #f8fafc;">
    <form onsubmit="event.preventDefault(); createSubtask('{{ $task->id }}', this)">
        <div style="display: flex; gap: 10px;">
            <input type="text" name="title" placeholder="New subtask..." required style="flex:1; padding: 5px 10px; border: 1px solid #cbd5e1; border-radius: 4px; font-size: 0.9rem;">
            <button type="submit" class="btn" style="padding: 2px 10px; font-size: 0.8rem;">Add</button>
        </div>
    </form>
</div>

<!-- Recursive Render Children -->
@if($task->subtasks && $task->subtasks->count() > 0)
    @foreach($task->subtasks as $subtask)
        @include('task::partials.recursive_task', ['task' => $subtask, 'level' => $level + 1])
    @endforeach
@endif
