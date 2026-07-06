@extends('admin.layout')

@section('judul', 'Detail Task')

@section('styles')
<style>
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
        border-color: #4e73df;
    }
    .todo-checkbox.checked {
        background: #4e73df;
        border-color: #4e73df;
    }
    .todo-checkbox.checked i {
        color: #fff;
        display: block;
    }
    .todo-checkbox i {
        display: none;
    }
</style>
@endsection

@section('konten')
<div style="background: white; border-radius: 16px; padding: 30px; border: 1px solid #edf2f7; max-width: 800px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 20px;">
        <h2 style="font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 0;">{{ $task->title }}</h2>
        <div style="display: flex; gap: 10px;">
            <button onclick="toggleEditModal()" class="btn" style="background: white; border: 1px solid #cbd5e1; color: #334155;">
                <i class="fas fa-edit"></i> Edit
            </button>
            <button onclick="deleteTask('{{ $task->uuid }}')" class="btn" style="background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca;">
                <i class="fas fa-trash"></i>
            </button>
            <a href="/admin/task" class="btn" style="background: #e2e8f0; color: #475569;">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div style="margin-bottom: 25px;">
        <div style="display: flex; gap: 10px; margin-bottom: 15px;">
             <span class="badge" style="background: {{ $task->status == 'done' ? '#dcfce7' : '#f1f5f9' }}; color: {{ $task->status == 'done' ? '#166534' : '#475569' }}; padding: 5px 12px; border-radius: 6px; font-weight: 600; text-transform: uppercase; font-size: 0.8rem;">
                 {{ ucfirst(str_replace('_', ' ', $task->status)) }}
             </span>
             <span class="badge" style="background: {{ $task->priority == 'urgent' ? '#fee2e2' : '#f1f5f9' }}; color: {{ $task->priority == 'urgent' ? '#991b1b' : '#475569' }}; padding: 5px 12px; border-radius: 6px; font-weight: 600; text-transform: uppercase; font-size: 0.8rem;">
                 {{ $task->priority }}
             </span>
             @if($task->is_ai_generated)
                 <span class="badge" style="background: #f3e8ff; color: #7e22ce; padding: 5px 12px; border-radius: 6px; font-weight: 600; font-size: 0.8rem;">
                     <i class="fas fa-magic"></i> AI Generated
                 </span>
             @endif
        </div>
        
        <div style="color: #475569; line-height: 1.6;">
            {{ $task->description ?? 'Tidak ada deskripsi.' }}
        </div>
    </div>

    <div style="border-top: 1px solid #f1f5f9; padding-top: 20px; font-size: 0.9rem; color: #64748b;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <div>
                <strong>Dibuat oleh:</strong> {{ $task->creator?->nama ?? 'Sistem' }}
            </div>
            <div>
                <strong>Ditugaskan ke:</strong> {{ $task->assignee?->nama ?? '-' }}
            </div>
            <div>
                <strong>Tenggat Waktu:</strong> {{ $task->due_at ? $task->due_at->format('d M Y, H:i') : '-' }}
            </div>
            <div>
                <strong>Dibuat pada:</strong> {{ $task->created_at->format('d M Y, H:i') }}
            </div>
        </div>
    </div>
    
    @if(!$task->parent_task_id)
    <div style="margin-bottom: 30px; border-top: 1px solid #f1f5f9; padding-top: 20px;">
        <h4 style="margin-bottom: 15px; color: #1e293b; display:flex; justify-content:space-between; align-items:center;">
             <span>Subtasks</span>
             <button onclick="document.getElementById('subtaskForm').style.display='block'" class="btn" style="padding: 5px 10px; font-size: 0.8rem;">
                 <i class="fas fa-plus"></i> Add Subtask
             </button>
        </h4>
        
        <!-- Add Subtask Form -->
        <div id="subtaskForm" style="display:none; background: #f8fafc; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
             <form id="createSubtaskForm">
                 <input type="hidden" name="parent_task_id" value="{{ $task->id }}">
                 <div style="margin-bottom: 10px;">
                     <input type="text" name="title" placeholder="Subtask title" required style="width: 100%; padding: 8px; border-radius: 6px; border: 1px solid #cbd5e1;">
                 </div>
                 <div style="margin-bottom: 10px;">
                     <textarea name="description" placeholder="Description (optional)" style="width: 100%; padding: 8px; border-radius: 6px; border: 1px solid #cbd5e1;" rows="2"></textarea>
                 </div>
                 <div style="margin-bottom: 10px;">
                     <label style="font-size: 0.8rem; display:block; margin-bottom: 5px;">Due Date</label>
                     <input type="datetime-local" name="due_at" style="width: 100%; padding: 8px; border-radius: 6px; border: 1px solid #cbd5e1;">
                 </div>
                 <div style="display: flex; gap: 10px;">
                     <button type="submit" class="btn" style="font-size: 0.8rem;">Save</button>
                     <button type="button" class="btn" style="background: #cbd5e1; color: #334155; font-size: 0.8rem;" onclick="document.getElementById('subtaskForm').style.display='none'">Cancel</button>
                 </div>
             </form>
        </div>

        <ul style="list-style: none; padding: 0;">
            @foreach($task->subtasks as $subtask)
                <li style="display: flex; align-items: flex-start; gap: 10px; padding: 12px; background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; margin-bottom: 8px;">
                     <div class="todo-checkbox {{ $subtask->status == 'done' ? 'checked' : '' }}" 
                          onclick="toggleStatus('{{ $subtask->uuid }}', '{{ $subtask->status == 'done' ? 'pending' : 'done' }}')"
                          style="width: 20px; height: 20px; margin-top: 3px;">
                         <i class="fas fa-check" style="font-size: 0.7rem;"></i>
                     </div>
                     <div style="flex: 1;">
                         <div style="font-weight: 600; font-size: 0.95rem; text-decoration: {{ $subtask->status == 'done' ? 'line-through' : 'none' }}; color: {{ $subtask->status == 'done' ? '#94a3b8' : '#1e293b' }}">
                             {{ $subtask->title }}
                         </div>
                         @if($subtask->description)
                             <div style="font-size: 0.85rem; color: #64748b; margin-top: 2px;">{{ $subtask->description }}</div>
                         @endif
                         @if($subtask->due_at)
                             <div style="font-size: 0.75rem; color: {{ $subtask->due_at < now() && $subtask->status != 'done' ? '#ef4444' : '#64748b' }}; margin-top: 4px;">
                                 <i class="far fa-clock"></i> {{ $subtask->due_at->format('d M Y, H:i') }}
                             </div>
                         @endif
                     </div>
                     <div>
                         <a href="/admin/task/{{ $subtask->uuid }}" style="color: #64748b;"><i class="fas fa-chevron-right"></i></a>
                     </div>
                </li>
            @endforeach
        </ul>
        </ul>
    </div>
    @endif

    <!-- Main Task Completion Action -->
    <div style="margin-top: 20px; padding: 15px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; display: flex; align-items: center; gap: 15px;">
        <div class="todo-checkbox {{ $task->status == 'done' ? 'checked' : '' }}" 
             onclick="toggleStatus('{{ $task->uuid }}', '{{ $task->status == 'done' ? 'pending' : 'done' }}')"
             style="width: 24px; height: 24px; cursor: pointer; background: {{ $task->status == 'done' ? '#4e73df' : 'white' }}; border: 2px solid {{ $task->status == 'done' ? '#4e73df' : '#cbd5e1' }}; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-check" style="color: white; font-size: 0.9rem; display: {{ $task->status == 'done' ? 'block' : 'none' }}"></i>
        </div>
        <div>
            <div style="font-weight: 600; color: #1e293b;">Mark Task as Done</div>
            <div style="font-size: 0.85rem; color: #64748b;">Click to complete this main task</div>
        </div>
    </div>
    
    @if($task->activities->count() > 0)
    <div style="margin-top: 30px;">
        <h4 style="margin-bottom: 15px; color: #1e293b;">Riwayat Aktivitas</h4>
        <ul style="list-style: none; padding: 0;">
            @foreach($task->activities as $activity)
                <li style="border-left: 2px solid #e2e8f0; padding-left: 15px; margin-bottom: 15px; position: relative;">
                    <div style="position: absolute; left: -5px; top: 0; width: 8px; height: 8px; border-radius: 50%; background: #94a3b8;"></div>
                    <div style="font-size: 0.85rem; color: #64748b;">{{ $activity->created_at->diffForHumans() }}</div>
                    <div style="color: #334155;">{{ $activity->details }}</div>
                </li>
            @endforeach
        </ul>
    </div>
    @endif
    <!-- Edit Modal -->
    <div id="editTaskModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:100; align-items:center; justify-content:center;">
        <div style="background:white; padding:25px; border-radius:12px; width:100%; max-width:500px;">
            <h3 style="margin-bottom:20px; font-size:1.2rem;">Edit Task</h3>
            <form id="editTaskForm">
                <input type="hidden" name="uuid" value="{{ $task->uuid }}">
                <div style="margin-bottom:15px;">
                    <label style="display:block; font-weight:500; margin-bottom:5px;">Title</label>
                    <input type="text" name="title" value="{{ $task->title }}" required style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px;">
                </div>
                <div style="margin-bottom:15px;">
                    <label style="display:block; font-weight:500; margin-bottom:5px;">Description</label>
                    <textarea name="description" rows="4" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px;">{{ $task->description }}</textarea>
                </div>
                <div style="margin-bottom:15px;">
                     <label style="display:block; font-weight:500; margin-bottom:5px;">Due Date</label>
                     <input type="datetime-local" name="due_at" value="{{ $task->due_at ? $task->due_at->format('Y-m-d\TH:i') : '' }}" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px;">
                </div>
                <div style="display:flex; justify-content:flex-end; gap:10px;">
                     <button type="button" onclick="toggleEditModal()" class="btn" style="background:#e2e8f0; color:#334155;">Cancel</button>
                     <button type="submit" class="btn">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleEditModal() {
        const el = document.getElementById('editTaskModal');
        el.style.display = el.style.display === 'flex' ? 'none' : 'flex';
    }

    async function deleteTask(uuid) {
        if(!confirm('Are you sure you want to delete this task?')) return;
        
        try {
            const res = await fetch(`/v1/tasks/${uuid}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            if(res.ok) {
                window.location.href = '/admin/task';
            }
        } catch(e) {
            alert('Error deleting task');
        }
    }

    document.getElementById('editTaskForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const uuid = this.uuid.value;
        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());
        
        try {
            const res = await fetch(`/v1/tasks/${uuid}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            });
            
            if(res.ok) {
                window.location.reload();
            } else {
                alert('Update failed');
            }
        } catch(err) {
            console.error(err);
        }
    });

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

    document.getElementById('createSubtaskForm')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        const data = Object.fromEntries(fd.entries());
        data.priority = 'medium'; // Default priority
        
        try {
            const res = await fetch('/v1/tasks', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            });
            
            if(res.ok) {
                window.location.reload();
            } else {
                alert('Failed to create subtask');
            }
        } catch(err) {
            console.error(err);
        }
    });
</script>
@endsection
