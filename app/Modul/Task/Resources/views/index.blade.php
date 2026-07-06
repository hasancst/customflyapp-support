@extends('admin.layout')

@section('judul', 'Tasks')

@section('styles')
<style>
    :root {
        --todo-sidebar-width: 280px;
        --todo-bg: #ffffff;
        --todo-hover: #f3f6fa;
        --todo-checked: #7c7c7c;
        --primary-color: #4e73df;
    }

    .todo-wrapper {
        display: flex;
        height: calc(100vh - 180px);
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        border: 1px solid #edf2f7;
        overflow: hidden;
    }

    /* Sidebar */
    .todo-sidebar {
        width: var(--todo-sidebar-width);
        border-right: 1px solid #edf2f7;
        padding: 20px;
        background: #f8fafc;
        display: flex;
        flex-direction: column;
    }

    .todo-nav-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 15px;
        color: #64748b;
        text-decoration: none;
        border-radius: 8px;
        margin-bottom: 5px;
        font-weight: 500;
        transition: all 0.2s;
        cursor: pointer;
    }

    .todo-nav-item:hover, .todo-nav-item.active {
        background: #e2e8f0;
        color: #334155;
    }

    .todo-nav-item.active {
        background: #dbeafe;
        color: var(--primary-color);
        font-weight: 600;
    }

    /* Main Content */
    .todo-main {
        flex: 1;
        display: flex;
        flex-direction: column;
        background: #fff;
    }

    .todo-header {
        padding: 20px 30px;
        border-bottom: 1px solid #edf2f7;
    }

    .todo-header h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 5px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .current-date {
        color: #94a3b8;
        font-size: 0.9rem;
    }

    /* Task List */
    .todo-list {
        flex: 1;
        overflow-y: auto;
        padding: 0;
    }

    .todo-item {
        display: flex;
        align-items: center;
        padding: 15px 30px;
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.2s;
        cursor: pointer;
    }

    .todo-item:hover {
        background: var(--todo-hover);
    }

    .todo-checkbox {
        width: 22px;
        height: 22px;
        border: 2px solid #cbd5e1;
        border-radius: 50%;
        margin-right: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        flex-shrink: 0;
    }

    .todo-checkbox:hover {
        border-color: var(--primary-color);
    }

    .todo-checkbox.checked {
        background: var(--primary-color);
        border-color: var(--primary-color);
    }

    .todo-checkbox.checked i {
        color: #fff;
        font-size: 0.8rem;
        display: block;
    }

    .todo-checkbox i {
        display: none;
    }

    .todo-content {
        flex: 1;
        min-width: 0;
    }

    .todo-title {
        font-size: 1rem;
        color: #1e293b;
        margin-bottom: 4px;
        transition: color 0.2s;
    }

    .todo-item.completed .todo-title {
        color: #94a3b8;
        text-decoration: line-through;
    }

    .todo-meta {
        font-size: 0.8rem;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .todo-meta span {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .todo-actions {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .priority-indicator {
        font-size: 0.75rem;
        text-transform: uppercase;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 4px;
    }
    
    .priority-high { color: #ef4444; background: #fee2e2; }
    .priority-urgent { color: #fff; background: #dc2626; }

    /* New Task Input */
    .todo-input-area {
        padding: 15px 30px;
        background: #f8fafc; /* Slightly different bg */
        border-top: 1px solid #edf2f7;
    }
    
    .todo-input-wrapper {
        display: flex;
        align-items: center;
        background: #fff;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 5px 15px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.03);
    }
    
    .todo-input-wrapper:focus-within {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.1);
    }

    .todo-input {
        flex: 1;
        border: none;
        padding: 10px;
        font-size: 0.95rem;
        outline: none;
    }

    /* Scrollbar */
    .todo-list::-webkit-scrollbar {
        width: 6px;
    }
    .todo-list::-webkit-scrollbar-track {
        background: transparent;
    }
    .todo-list::-webkit-scrollbar-thumb {
        background-color: #cbd5e1;
        border-radius: 20px;
    }
</style>
@endsection

@section('konten')

<div class="todo-wrapper">
    <!-- Sidebar -->
    <div class="todo-sidebar">
        <div style="margin-bottom: 20px;">
            <button class="btn" onclick="toggleTaskModal()" style="width: 100%; justify-content: center;">
                <i class="fas fa-plus"></i> New Task
            </button>
        </div>
        
        <a href="#" class="todo-nav-item {{ !request('filter') ? 'active' : '' }}" onclick="filterTasks('all')">
            <i class="fas fa-sun" style="color: #f59e0b;"></i> My Day
        </a>
        <a href="#" class="todo-nav-item {{ request('filter') == 'important' ? 'active' : '' }}" onclick="filterTasks('important')">
            <i class="far fa-star text-danger"></i> Important
        </a>
        <a href="#" class="todo-nav-item {{ request('filter') == 'planned' ? 'active' : '' }}" onclick="filterTasks('planned')">
            <i class="far fa-calendar-alt text-info"></i> Planned
        </a>
        <a href="#" class="todo-nav-item {{ request('filter') == 'assigned' ? 'active' : '' }}" onclick="filterTasks('assigned')">
            <i class="far fa-user text-success"></i> Assigned to me
        </a>
        <div style="border-top: 1px solid #e2e8f0; margin: 15px 0;"></div>
        <a href="#" class="todo-nav-item" onclick="toggleAiModal()">
            <i class="fas fa-magic" style="color: #8b5cf6;"></i> AI Generator
        </a>
    </div>

    <!-- Main Content -->
    <div class="todo-main">
        <div class="todo-header">
            <h2>
                @if(request('filter') == 'important') <i class="far fa-star text-danger"></i> Important
                @elseif(request('filter') == 'planned') <i class="far fa-calendar-alt text-info"></i> Planned
                @else <i class="fas fa-sun text-warning"></i> My Day
                @endif
            </h2>
            <div class="current-date">{{ now()->format('l, F j') }}</div>
        </div>

        <!-- Quick Add -->
        <div class="todo-input-area">
             <form id="quickAddForm" class="todo-input-wrapper">
                 <i class="fas fa-plus" style="color: var(--primary-color);"></i>
                 <input type="text" name="title" class="todo-input" placeholder="Add a task" required>
                 <button type="submit" style="display: none;"></button>
             </form>
        </div>

        <!-- List -->
        <div class="todo-list">
            @forelse($tasks as $task)
                @include('task::partials.recursive_task', ['task' => $task, 'level' => 0])
            @empty
            <div style="text-align: center; padding: 50px; color: #94a3b8;">
                <i class="fas fa-clipboard-check" style="font-size: 3rem; margin-bottom: 20px; opacity: 0.5;"></i>
                <p>No tasks found for this filter.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- AI Modal (Keep existing) -->
<div class="modal" id="aiModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 50; align-items: center; justify-content: center;">
    <div class="modal-content" style="background: #fff; border-radius: 16px; width: 100%; max-width: 500px; padding: 25px;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
            <h3 style="font-size: 1.2rem; font-weight: 700;">AI Task Generator</h3>
            <button onclick="toggleAiModal()" style="background:none; border:none; cursor:pointer;">&times;</button>
        </div>
        <textarea id="aiInput" rows="5" placeholder="Paste conversation..." style="width:100%; padding:10px; border-radius:8px; border:1px solid #edf2f7; margin-bottom: 15px;"></textarea>
        <button onclick="generateTasks()" class="btn" style="width:100%; justify-content:center;">Generate</button>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function toggleTaskModal() {
        // Since we removed the modal earlier for the new design, we can either re-add it or just focus the quick add input
        document.querySelector('.todo-input').focus();
    }

    function toggleAiModal() {
        const el = document.getElementById('aiModal');
        el.style.display = el.style.display === 'flex' ? 'none' : 'flex';
    }

    function filterTasks(filter) {
        // Simple client-side redirect for now, in a real SPA we would fetch content
        let url = new URL(window.location.href);
        url.searchParams.set('filter', filter);
        window.location.href = url.toString();
    }

    async function toggleStatus(uuid, newStatus) {
        try {
            const res = await fetch(`/v1/tasks/${uuid}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ status: newStatus })
            });
            if(res.ok) {
                window.location.reload();
            }
        } catch(e) { 
            console.error(e); 
        }
    }

    document.getElementById('quickAddForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const input = this.title;
        const title = input.value;
        if(!title) return;

        try {
            const res = await fetch('/v1/tasks', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ 
                    title: title,
                    priority: 'medium' 
                })
            });
            
            if(res.ok) {
                // Clear input immediately for better UX
                input.value = ''; 
                // Reload to show new task
                window.location.reload();
            }
        } catch(err) {
            console.error(err);
        }
    });

    // Ensure Enter key triggers submit specifically if form submission is quirky
    document.querySelector('.todo-input').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            document.getElementById('quickAddForm').dispatchEvent(new Event('submit'));
        }
    });

    async function generateTasks() {
        const content = document.getElementById('aiInput').value;
        if(!content) return;
        
        try {
            const res = await fetch('/v1/tasks/generate-ai', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ content })
            });
            if(res.ok) window.location.reload();
        } catch(err) { alert('Failed'); }
    }
    function toggleSubtaskForm(uuid) {
        const el = document.getElementById(`subtask-form-${uuid}`);
        el.style.display = el.style.display === 'none' ? 'block' : 'none';
        if(el.style.display === 'block') {
             el.querySelector('input').focus();
        }
    }

    async function createSubtask(parentId, form) {
        const title = form.title.value;
        if(!title) return;
        
        try {
            const res = await fetch('/v1/tasks', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ 
                    title: title,
                    priority: 'medium',
                    parent_task_id: parentId
                })
            });
            
            if(res.ok) {
                window.location.reload();
            }
        } catch(err) {
            console.error(err);
        }
    }
</script>
@endsection
