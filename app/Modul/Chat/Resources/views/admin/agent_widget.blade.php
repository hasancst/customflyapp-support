@if(in_array('chat', array_map('strtolower', $modulAktif ?? [])))
<div id="admin-chat-widget" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999; font-family: 'Outfit', sans-serif;">
    <!-- Toggle Button -->
    <button onclick="toggleAdminChat()" style="background: #4e73df; color: white; border: none; padding: 12px 20px; border-radius: 30px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); cursor: pointer; display: flex; align-items: center; gap: 10px; font-weight: 600;">
        <i class="fas fa-comments"></i> 
        <span>Live Chat</span>
        <span id="chat-count" style="background: #ef4444; color: white; font-size: 0.75rem; padding: 2px 6px; border-radius: 10px; display: none;">0</span>
    </button>

    <!-- Chat Panel -->
    <div id="admin-chat-panel" style="display: none; width: 800px; height: 500px; background: white; border-radius: 12px; box-shadow: 0 5px 25px rgba(0,0,0,0.2); position: absolute; bottom: 60px; right: 0; overflow: hidden; border: 1px solid #e2e8f0; grid-template-columns: 250px 1fr;">
        
        <!-- Sessions List -->
        <div style="background: #f8fafc; border-right: 1px solid #e2e8f0; display: flex; flex-direction: column;">
            <div style="padding: 15px; border-bottom: 1px solid #e2e8f0; font-weight: 600; color: #1e293b;">
                Active Sessions
            </div>
            <div id="chat-sessions-list" style="flex: 1; overflow-y: auto; padding: 10px;">
                <!-- Sessions populated via JS -->
                <div style="text-align: center; color: #94a3b8; font-size: 0.9rem; margin-top: 20px;">Loading...</div>
            </div>
        </div>

        <!-- Chat Area -->
        <div style="display: flex; flex-direction: column; height: 100%;">
            <!-- Header -->
            <div id="chat-header" style="padding: 15px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: white;">
                <div id="current-visitor-name" style="font-weight: 600; color: #1e293b;">Select a chat</div>
                <div style="font-size: 0.8rem; color: #64748b;" id="current-visitor-status"></div>
            </div>

            <!-- Messages -->
            <div id="chat-messages" style="flex: 1; overflow-y: auto; padding: 20px; background: #fff;">
                <div style="text-align: center; color: #cbd5e1; margin-top: 100px;">
                    <i class="far fa-comments" style="font-size: 3rem; margin-bottom: 10px;"></i>
                    <p>Select a session to start chatting</p>
                </div>
            </div>

            <!-- Input -->
            <div id="chat-input-area" style="padding: 15px; border-top: 1px solid #e2e8f0; background: #f8fafc; display: none;">
                <form onsubmit="event.preventDefault(); sendAdminMessage()" style="display: flex; gap: 10px;">
                    <input type="text" id="admin-message-input" placeholder="Type your reply..." style="flex: 1; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; outline: none;">
                    <button type="submit" class="btn" style="background: #4e73df; color: white; border: none; padding: 0 20px; border-radius: 6px; cursor: pointer;">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
let activeSessionId = null;
let pollInterval = null;

function toggleAdminChat() {
    const panel = document.getElementById('admin-chat-panel');
    const display = panel.style.display === 'none' ? 'grid' : 'none';
    panel.style.display = display;
    
    if(display === 'grid') {
        loadSessions();
        if(!pollInterval) pollInterval = setInterval(loadSessions, 5000); // Poll every 5s
    } else {
        clearInterval(pollInterval);
        pollInterval = null;
    }
}

async function loadSessions() {
    try {
        const res = await fetch('/admin/chat/api/active-sessions');
        const sessions = await res.json();
        
        const list = document.getElementById('chat-sessions-list');
        const countBadge = document.getElementById('chat-count');
        
        if(sessions.length > 0) {
            countBadge.innerText = sessions.length;
            countBadge.style.display = 'inline-block';
        } else {
            countBadge.style.display = 'none';
        }
        
        let html = '';
        sessions.forEach(s => {
            const isActive = activeSessionId === s.id;
            html += `
                <div onclick="selectSession(${s.id}, '${s.nama_pengunjung || 'Anonymous'}')" 
                     style="padding: 10px; border-radius: 6px; cursor: pointer; margin-bottom: 5px; background: ${isActive ? '#e0f2fe' : 'white'}; border: 1px solid ${isActive ? '#bae6fd' : 'transparent'}; transition: bg 0.2s;">
                    <div style="font-weight: 600; font-size: 0.9rem; color: #1e293b;">${s.nama_pengunjung || 'Anonymous'}</div>
                    <div style="font-size: 0.75rem; color: #64748b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        ${s.last_message || '...'}
                    </div>
                </div>
            `;
        });
        
        if(sessions.length === 0) {
            html = '<div style="text-align: center; padding: 20px; color: #94a3b8; font-size: 0.85rem;">No active chats</div>';
        }
        
        // Only update HTML if we aren't dragging/selecting (simple check)
        // Ideally use VDOM, but for now just innerHTML
        // To preserve selection state visually we rely on activeSessionId check above
        list.innerHTML = html;
        
    } catch(e) {
        console.error('Failed to load sessions', e);
    }
}

async function selectSession(id, name) {
    activeSessionId = id;
    document.getElementById('current-visitor-name').innerText = name;
    document.getElementById('chat-input-area').style.display = 'block';
    loadMessages(id);
    
    // Refresh list to highlight
    loadSessions();
}

async function loadMessages(sessionId) {
    if(!sessionId) return;
    try {
        const res = await fetch(`/admin/chat/api/messages/${sessionId}`);
        const messages = await res.json();
        
        const container = document.getElementById('chat-messages');
        let html = '';
        
        messages.forEach(msg => {
            const isMe = msg.sender === 'agent' || msg.sender === 'admin'; // Adjust based on sender value
            const isAi = msg.sender === 'ai';
            const align = (isMe || isAi) ? 'flex-end' : 'flex-start';
            const bg = isMe ? '#4e73df' : (isAi ? '#f3e8ff' : '#f1f5f9');
            const color = isMe ? 'white' : '#1e293b';
            
            html += `
                <div style="display: flex; justify-content: ${align}; margin-bottom: 10px;">
                    <div style="max-width: 70%; background: ${bg}; color: ${color}; padding: 8px 12px; border-radius: 12px; font-size: 0.9rem; position: relative;">
                        ${isAi ? '<i class="fas fa-robot" style="margin-right:5px; font-size:0.8rem;"></i>' : ''}
                        ${msg.message}
                        <div style="font-size: 0.65rem; opacity: 0.7; margin-top: 4px; text-align: right;">${new Date(msg.timestamp).toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'})}</div>
                    </div>
                </div>
            `;
        });
        
        container.innerHTML = html;
        container.scrollTop = container.scrollHeight;
        
    } catch(e) {
        console.error('Failed to load messages', e);
    }
}

async function sendAdminMessage() {
    const input = document.getElementById('admin-message-input');
    const msg = input.value;
    if(!msg || !activeSessionId) return;
    
    // Optimistic UI
    const container = document.getElementById('chat-messages');
    container.innerHTML += `
        <div style="display: flex; justify-content: flex-end; margin-bottom: 10px;">
            <div style="max-width: 70%; background: #4e73df; color: white; padding: 8px 12px; border-radius: 12px; font-size: 0.9rem;">
                ${msg}
                <div style="font-size: 0.65rem; opacity: 0.7; margin-top: 4px; text-align: right;">Just now</div>
            </div>
        </div>
    `;
    container.scrollTop = container.scrollHeight;
    input.value = '';
    
    try {
        await fetch('/admin/chat/api/message', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                session_id: activeSessionId,
                message: msg
            })
        });
        
        // Reload to confirm and get timestamp
        loadMessages(activeSessionId);
    } catch(e) {
        alert('Failed to send');
    }
}
</script>
@endif
