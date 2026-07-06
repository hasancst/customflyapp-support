<div class="task-card" onclick="window.location.href='/admin/task/{{ $task->uuid }}'">
    @if($task->is_ai_generated)
        <div class="ai-badge"><i class="fas fa-magic"></i> AI</div>
    @endif
    <div class="task-meta">
        <span class="badge-priority priority-{{ $task->priority }}">{{ $task->priority }}</span>
        @if($task->due_at)
             <span style="font-size:0.75rem; color:{{ $task->due_at < now() ? '#ef4444' : '#64748b' }};">
                 <i class="far fa-clock"></i> {{ $task->due_at->format('M d') }}
             </span>
        @endif
    </div>
    <div class="task-title">{{ $task->title }}</div>
    <div class="task-desc">{{ $task->description }}</div>
    
    <div class="task-footer">
        <div>
            @if($task->tiket_id)
                <i class="fas fa-ticket-alt"></i> #{{ $task->tiket_id }}
            @endif
        </div>
        <div class="avatar-stack">
            @if($task->assignee)
                 <img src="https://ui-avatars.com/api/?name={{ urlencode($task->assignee->nama) }}&background=cbd5e1&color=334155" class="avatar-small" title="{{ $task->assignee->nama }}">
            @else
                 <span style="font-size:0.7rem; color:#94a3b8;">Unassigned</span>
            @endif
        </div>
    </div>
</div>
