@if(in_array('chat', array_map('strtolower', $modulAktif ?? [])) && !request()->is('admin/chat/sessions*'))
<div id="admin-chat-widget" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999; font-family: 'Outfit', sans-serif;">
    <!-- Toggle Button -->
    <button onclick="toggleAdminChat()" style="background: #4e73df; color: white; border: none; padding: 12px 20px; border-radius: 30px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); cursor: pointer; display: flex; align-items: center; gap: 10px; font-weight: 600;">
        <i class="fas fa-comments"></i> 
        <span>Live Chat</span>
        <span id="chat-count" style="background: #ef4444; color: white; font-size: 0.75rem; padding: 2px 6px; border-radius: 10px; display: none;">0</span>
    </button>

    <!-- Chat Panel -->
    <div id="admin-chat-panel" style="display: none; width: 800px; height: 520px; background: white; border-radius: 12px; box-shadow: 0 5px 25px rgba(0,0,0,0.2); position: fixed; bottom: 80px; right: 20px; overflow: hidden; border: 1px solid #e2e8f0; grid-template-columns: 250px 1fr; z-index: 10000;">
        
        <!-- Sessions List -->
        <div style="background: #f8fafc; border-right: 1px solid #e2e8f0; display: flex; flex-direction: column; height: 520px; overflow: hidden;">
            <div style="padding: 15px; border-bottom: 1px solid #e2e8f0; font-weight: 600; color: #1e293b;">
                Active Sessions
            </div>
            <div id="chat-sessions-list" style="flex: 1; overflow-y: auto; padding: 10px;">
                <!-- Sessions populated via JS -->
                <div style="text-align: center; color: #94a3b8; font-size: 0.9rem; margin-top: 20px;">Loading...</div>
            </div>
        </div>

        <!-- Chat Area -->
        <div style="display: flex; flex-direction: column; height: 520px; overflow: hidden;">
            <!-- Header -->
            <div id="chat-header" style="padding: 15px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: white;">
                <div id="current-visitor-name" style="font-weight: 600; color: #1e293b;">Select a chat</div>
                <div style="font-size: 0.8rem; color: #64748b;" id="current-visitor-status"></div>
            </div>

            <!-- Messages -->
            <div id="chat-messages" style="flex: 1; overflow-y: auto; padding: 20px; background: #fff; min-height: 0;">
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
let pollInterval    = null;
let msgPollInterval = null;
// Track last seen message id per session for unread badge
const lastSeenIds   = {};
let totalUnread     = 0;

function toggleAdminChat() {
    const panel = document.getElementById('admin-chat-panel');
    const isOpen = panel.style.display !== 'none';
    if (isOpen) {
        panel.style.display = 'none';
        clearInterval(pollInterval);
        clearInterval(msgPollInterval);
        pollInterval = msgPollInterval = null;
    } else {
        panel.style.display = 'grid';
        loadSessions();
        if (!pollInterval) pollInterval = setInterval(loadSessions, 5000);
    }
}

async function loadSessions() {
    try {
        const res      = await fetch('/admin/chat/api/active-sessions');
        const sessions = await res.json();

        // Calculate unread = sessions with last_message_id > lastSeenIds[id]
        totalUnread = sessions.reduce((sum, s) => {
            const seen = lastSeenIds[s.id] ?? 0;
            return sum + (s.last_message_id > seen && s.last_message?.length > 0 ? 1 : 0);
        }, 0);

        const badge = document.getElementById('chat-count');
        if (totalUnread > 0) {
            badge.innerText = totalUnread;
            badge.style.display = 'inline-block';
        } else {
            badge.style.display = 'none';
        }

        const list = document.getElementById('chat-sessions-list');
        if (sessions.length === 0) {
            list.innerHTML = '<div style="text-align:center;padding:20px;color:#94a3b8;font-size:0.85rem;">No active chats</div>';
            return;
        }

        list.innerHTML = sessions.map(s => {
            const isActive  = activeSessionId === s.id;
            const seen      = lastSeenIds[s.id] ?? 0;
            const hasUnread = s.last_message_id > seen && s.id !== activeSessionId;
            // Use shop_name (derived from myshopify domain) or fallback
            const displayName = s.shop_name || s.nama_pengunjung || 'Anonymous';

            return `<div class="admin-session-item"
                data-session-id="${s.id}"
                data-name="${(displayName).replace(/"/g,'&quot;')}"
                data-status="${s.status || 'aktif'}"
                data-tiket="${s.tiket_id || ''}"
                style="padding:10px;border-radius:6px;margin-bottom:5px;
                       background:${isActive ? '#e0f2fe' : hasUnread ? '#FFF7ED' : 'white'};
                       border:1px solid ${isActive ? '#bae6fd' : hasUnread ? '#FED7AA' : 'transparent'};
                       transition:background 0.2s;position:relative;">
                <div class="session-click-area" style="cursor:pointer;">
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <div style="font-weight:600;font-size:0.9rem;color:#1e293b;">${displayName}</div>
                        ${hasUnread ? '<span style="background:#ef4444;color:white;font-size:0.65rem;padding:1px 6px;border-radius:99px;font-weight:700;">NEW</span>' : ''}
                    </div>
                    <div style="font-size:0.75rem;color:#64748b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${s.last_message || '...'}</div>
                </div>
                <div style="display:flex;gap:4px;margin-top:6px;">
                    ${s.status !== 'selesai' ? `
                    <button onclick="widgetQuickClose(${s.id}, event)" title="Close chat"
                        style="padding:3px 9px;background:#fef2f2;color:#ef4444;border:1px solid #fecaca;border-radius:6px;cursor:pointer;font-size:11px;font-weight:700;">
                        ✕ Close
                    </button>` : ''}
                    ${s.status === 'aktif' && !s.tiket_id ? `
                    <button onclick="widgetQuickEscalate(${s.id}, event)" title="Create ticket"
                        style="padding:3px 9px;background:#ede9fe;color:#6d28d9;border:1px solid #c4b5fd;border-radius:6px;cursor:pointer;font-size:11px;font-weight:700;">
                        🎫 Ticket
                    </button>` : ''}
                </div>
            </div>`;
        }).join('');

        // Attach click listeners via event delegation (avoids quote escaping issues)
        if (!list._delegated) {
            list._delegated = true;
            list.addEventListener('click', function(e) {
                // Ignore button clicks — they have their own handlers
                if (e.target.closest('button')) return;
                const area = e.target.closest('.session-click-area');
                if (!area) return;
                const item = area.closest('.admin-session-item');
                if (!item) return;
                const sid  = parseInt(item.dataset.sessionId);
                const name = item.dataset.name;
                selectSession(sid, name);
            });
        }

    } catch(e) { console.error('loadSessions error', e); }
}

async function widgetQuickClose(sessionId, e) {
    e.stopPropagation();
    if (!confirm('Close this chat session?')) return;
    try {
        await fetch('/admin/chat/api/close', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ session_id: sessionId }),
        });
        if (activeSessionId === sessionId) {
            document.getElementById('chat-input-area').style.display = 'none';
        }
        await loadSessions();
    } catch(err) { alert('Failed to close session.'); }
}

async function widgetQuickEscalate(sessionId, e) {
    e.stopPropagation();
    if (!confirm('Create a support ticket for this chat?')) return;
    try {
        const res  = await fetch('/admin/chat/api/escalate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ session_id: sessionId }),
        });
        const data = await res.json();
        if (data.success) await loadSessions();
        else alert('Failed to create ticket.');
    } catch(err) { alert('Failed to escalate.'); }
}

async function selectSession(id, name) {
    activeSessionId = id;

    // Mark as seen
    const res  = await fetch(`/admin/chat/api/messages/${id}`);
    const msgs = await res.json();
    if (msgs.length > 0) lastSeenIds[id] = msgs[msgs.length - 1].id ?? 0;

    // Make sure panel is open
    const panel = document.getElementById('admin-chat-panel');
    if (panel.style.display === 'none') {
        panel.style.display = 'grid';
        if (!pollInterval) pollInterval = setInterval(loadSessions, 5000);
    }

    document.getElementById('current-visitor-name').innerText = name;
    document.getElementById('chat-input-area').style.display  = 'block';

    renderMessages(msgs);

    // Poll messages for active session
    if (msgPollInterval) clearInterval(msgPollInterval);
    msgPollInterval = setInterval(() => loadMessages(activeSessionId), 5000);

    loadSessions();
}

function renderMessages(messages) {
    const container = document.getElementById('chat-messages');
    if (!messages.length) {
        container.innerHTML = '<div style="text-align:center;color:#cbd5e1;margin-top:60px;"><p>No messages yet</p></div>';
        return;
    }
    container.innerHTML = messages.map(msg => {
        const isMe    = msg.sender === 'agen';
        const isAi    = msg.sender === 'ai';
        const align   = isMe ? 'flex-end' : 'flex-start';
        const bg      = isMe ? '#4e73df' : isAi ? '#f3e8ff' : '#f1f5f9';
        const color   = isMe ? 'white' : '#1e293b';
        const label   = isMe ? 'You' : isAi ? '🤖 AI' : 'Customer';
        const time    = msg.timestamp ? new Date(msg.timestamp).toLocaleTimeString([], {hour:'2-digit',minute:'2-digit'}) : '';
        return `<div style="display:flex;flex-direction:column;align-items:${align};margin-bottom:10px;">
            <div style="font-size:0.7rem;color:#94a3b8;margin-bottom:3px;">${label}</div>
            <div style="max-width:70%;background:${bg};color:${color};padding:8px 12px;border-radius:12px;font-size:0.9rem;">
                ${msg.message}
                <div style="font-size:0.65rem;opacity:0.7;margin-top:4px;text-align:right;">${time}</div>
            </div>
        </div>`;
    }).join('');
    container.scrollTop = container.scrollHeight;
}

async function loadMessages(sessionId) {
    if (!sessionId) return;
    try {
        const res  = await fetch(`/admin/chat/api/messages/${sessionId}`);
        const msgs = await res.json();
        if (msgs.length > 0) lastSeenIds[sessionId] = msgs[msgs.length - 1].id ?? 0;
        renderMessages(msgs);
    } catch(e) { console.error('loadMessages error', e); }
}

async function sendAdminMessage() {
    const input = document.getElementById('admin-message-input');
    const msg   = input.value.trim();
    if (!msg || !activeSessionId) return;
    input.value    = '';
    input.disabled = true;
    try {
        const res = await fetch('/admin/chat/api/message', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ session_id: activeSessionId, message: msg })
        });
        if (res.ok) await loadMessages(activeSessionId);
        else { alert('Failed to send.'); input.value = msg; }
    } catch(e) { alert('Connection error.'); input.value = msg; }
    finally { input.disabled = false; input.focus(); }
}

// Auto-load sessions badge even when panel is closed
setInterval(async () => {
    if (document.getElementById('admin-chat-panel').style.display !== 'none') return;
    try {
        const res      = await fetch('/admin/chat/api/active-sessions');
        const sessions = await res.json();
        const unread   = sessions.reduce((sum, s) => {
            const seen = lastSeenIds[s.id] ?? 0;
            return sum + (s.last_message_id > seen && s.last_message?.length > 0 ? 1 : 0);
        }, 0);
        const badge = document.getElementById('chat-count');
        badge.innerText      = unread;
        badge.style.display  = unread > 0 ? 'inline-block' : 'none';
    } catch {}
}, 10000);
</script>
@endif
