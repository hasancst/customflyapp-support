@extends('admin.layout')

@section('judul', 'Chat Sessions')

@section('konten')
<style>
.chat-layout { display: grid; grid-template-columns: 320px 1fr; gap: 20px; height: calc(100vh - 180px); min-height: 500px; }
.session-list { background: white; border-radius: 14px; border: 1px solid #e2e8f0; overflow: hidden; display: flex; flex-direction: column; }
.session-list-header { padding: 16px 18px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; }
.session-item { padding: 14px 18px; border-bottom: 1px solid #f1f5f9; cursor: default; transition: background 0.15s; display: flex; flex-direction: column; }
.session-item:hover { background: #f8fafc; }
.session-item.active { background: #EEF2FF; border-left: 3px solid #6366f1; }
.session-items { overflow-y: auto; flex: 1; }
.status-badge { display: inline-block; padding: 2px 8px; border-radius: 99px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; }
.status-aktif    { background: #dbeafe; color: #1d4ed8; }
.status-eskalasi { background: #ede9fe; color: #6d28d9; }
.status-selesai  { background: #d1fae5; color: #065f46; }

.chat-panel { background: white; border-radius: 14px; border: 1px solid #e2e8f0; display: flex; flex-direction: column; overflow: hidden; }
.chat-panel-empty { display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; color: #94a3b8; gap: 12px; }
.chat-header { padding: 14px 20px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-shrink: 0; }
.chat-messages { flex: 1; overflow-y: auto; padding: 16px; display: flex; flex-direction: column; gap: 12px; background: #f8fafc; }
.msg-bubble { max-width: 75%; padding: 9px 13px; border-radius: 12px; font-size: 13px; line-height: 1.6; white-space: pre-wrap; }
.msg-visitor { align-self: flex-end; background: linear-gradient(135deg,#6366f1,#818cf8); color: white; border-radius: 12px 12px 4px 12px; }
.msg-ai      { align-self: flex-start; background: white; color: #1e293b; border: 1px solid #e0e7ff; border-radius: 12px 12px 12px 4px; }
.msg-agent   { align-self: flex-start; background: #ede9fe; color: #3730a3; border: 1px solid #c4b5fd; border-radius: 12px 12px 12px 4px; }
.msg-sender  { font-size: 10px; color: #94a3b8; margin-bottom: 3px; }
.chat-input  { padding: 12px 16px; border-top: 1px solid #e2e8f0; display: flex; gap: 8px; flex-shrink: 0; background: white; }
.chat-input textarea { flex: 1; padding: 9px 13px; border: 1px solid #e0e7ff; border-radius: 12px; font-size: 13px; font-family: inherit; resize: none; outline: none; }
.chat-input textarea:focus { border-color: #6366f1; }
.btn-send { padding: 9px 18px; background: linear-gradient(135deg,#6366f1,#818cf8); color: white; border: none; border-radius: 10px; cursor: pointer; font-weight: 700; font-size: 13px; white-space: nowrap; }
.btn-close-session { padding: 6px 14px; background: #fef2f2; color: #ef4444; border: 1px solid #fecaca; border-radius: 8px; cursor: pointer; font-size: 12px; font-weight: 700; }
.btn-escalate { padding: 6px 14px; background: #ede9fe; color: #6d28d9; border: 1px solid #c4b5fd; border-radius: 8px; cursor: pointer; font-size: 12px; font-weight: 700; }
</style>

<div style="margin-bottom:16px; display:flex; justify-content:space-between; align-items:center;">
    <h2 style="margin:0;"><i class="fas fa-comments"></i> Chat Sessions</h2>
    <span style="font-size:12px; color:#64748b;">Auto-refreshes every 5 seconds</span>
</div>

<div class="chat-layout">
    {{-- LEFT: Session List --}}
    <div class="session-list">
        <div class="session-list-header">
            <span style="font-weight:700; font-size:14px; color:#1e293b;">Active Sessions</span>
            <span id="active-count" style="background:#EEF2FF; color:#6366f1; padding:2px 10px; border-radius:99px; font-size:12px; font-weight:700;">0</span>
        </div>
        <div class="session-items" id="session-list">
            <div style="padding:32px; text-align:center; color:#94a3b8; font-size:13px;">Loading sessions...</div>
        </div>
        <div style="padding:12px 18px; border-top:1px solid #f1f5f9;">
            <a href="/admin/chat/sessions" style="font-size:12px; color:#6366f1;">View all sessions →</a>
        </div>
    </div>

    {{-- RIGHT: Chat Panel --}}
    <div class="chat-panel">
        <div class="chat-panel-empty" id="chat-empty">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            <span style="font-size:14px;">Select a session to start chatting</span>
        </div>
        <div id="chat-active" style="display:none; flex-direction:column; height:100%;">
            <div class="chat-header">
                <div>
                    <div style="font-weight:700; font-size:14px; color:#1e293b;" id="chat-visitor-name">—</div>
                    <div style="font-size:12px; color:#64748b;" id="chat-visitor-email">—</div>
                </div>
                <div style="display:flex; gap:8px; align-items:center;">
                    <span id="chat-status-badge" class="status-badge status-aktif">OPEN</span>
                    <button class="btn-escalate" id="btn-escalate" onclick="escalateSession()" style="display:none;">🎫 Create Ticket</button>
                    <button class="btn-close-session" id="btn-close" onclick="closeSession()">✕ Close</button>
                </div>
            </div>
            <div class="chat-messages" id="chat-messages"></div>
            <div class="chat-input" id="chat-input-area">
                <textarea id="reply-input" rows="2" placeholder="Type your reply... (Enter to send)"></textarea>
                <button class="btn-send" onclick="sendAdminReply()">Send</button>
            </div>
        </div>
    </div>
</div>

<script>
let currentSessionId   = null;
let lastMessageId      = 0;
let pollingInterval    = null;
let sessionsInterval   = null;

const STATUS_LABEL = { aktif: 'OPEN', eskalasi: 'ESCALATED', selesai: 'CLOSED' };
const STATUS_CLASS = { aktif: 'status-aktif', eskalasi: 'status-eskalasi', selesai: 'status-selesai' };

// ── Event delegation for session clicks ──────────────────────────────────────
document.getElementById('session-list').addEventListener('click', function(e) {
    const area = e.target.closest('.session-click-area');
    if (!area) return;
    const item = area.closest('.session-item');
    if (!item) return;
    const id      = parseInt(item.dataset.id);
    const name    = item.dataset.name;
    const email   = item.dataset.email;
    const status  = item.dataset.status;
    const tiketId = item.dataset.tiket ? parseInt(item.dataset.tiket) : null;
    selectSession(id, name, email, status, tiketId);
});

// ── Load active sessions list ─────────────────────────────────────────────────
async function loadSessions() {
    try {
        const res  = await fetch('/admin/chat/api/active-sessions');
        const data = await res.json();
        document.getElementById('active-count').textContent = data.length;

        const list = document.getElementById('session-list');
        if (data.length === 0) {
            list.innerHTML = '<div style="padding:32px;text-align:center;color:#94a3b8;font-size:13px;">No active sessions</div>';
            return;
        }
        list.innerHTML = data.map(s => `
            <div class="session-item ${s.id == currentSessionId ? 'active' : ''}" id="session-item-${s.id}"
                data-id="${s.id}"
                data-name="${escHtml(s.nama_pengunjung || 'Anonymous').replace(/"/g,'&quot;')}"
                data-email="${escHtml(s.email || '').replace(/"/g,'&quot;')}"
                data-status="${s.status || 'aktif'}"
                data-tiket="${s.tiket_id || ''}">
                <div class="session-click-area" style="flex:1; cursor:pointer;">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px;">
                        <span style="font-weight:600;font-size:13px;color:#1e293b;">${escHtml(s.nama_pengunjung || 'Anonymous')}</span>
                        <span class="status-badge ${STATUS_CLASS[s.status] || 'status-aktif'}">${STATUS_LABEL[s.status] || s.status}</span>
                    </div>
                    <div style="font-size:12px;color:#94a3b8;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${escHtml(s.email || '')}</div>
                    <div style="font-size:11px;color:#cbd5e1;margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${escHtml(s.last_message || '...')}</div>
                </div>
                <div style="display:flex;gap:4px;margin-top:8px;flex-shrink:0;">
                    ${s.status !== 'selesai' ? `
                    <button onclick="quickClose(${s.id}, event)" title="Close session"
                        style="padding:4px 10px;background:#fef2f2;color:#ef4444;border:1px solid #fecaca;border-radius:6px;cursor:pointer;font-size:11px;font-weight:700;">
                        ✕ Close
                    </button>
                    ` : ''}
                    ${s.status === 'aktif' && !s.tiket_id ? `
                    <button onclick="quickEscalate(${s.id}, event)" title="Create ticket"
                        style="padding:4px 10px;background:#ede9fe;color:#6d28d9;border:1px solid #c4b5fd;border-radius:6px;cursor:pointer;font-size:11px;font-weight:700;">
                        🎫
                    </button>
                    ` : ''}
                    <button onclick="quickDelete(${s.id}, event)" title="Delete permanently"
                        style="padding:4px 10px;background:#f8fafc;color:#94a3b8;border:1px solid #e2e8f0;border-radius:6px;cursor:pointer;font-size:11px;font-weight:700;">
                        🗑
                    </button>
                </div>
            </div>
        `).join('');
    } catch(e) { console.error(e); }
}

// ── Select a session to chat ──────────────────────────────────────────────────
async function selectSession(id, name, email, status, tiketId) {
    currentSessionId = id;
    lastMessageId    = 0;

    document.getElementById('chat-empty').style.display  = 'none';
    const activePanel = document.getElementById('chat-active');
    activePanel.style.display = 'flex';

    document.getElementById('chat-visitor-name').textContent  = name;
    document.getElementById('chat-visitor-email').textContent = email;
    updateStatusUI(status, tiketId);
    document.getElementById('chat-messages').innerHTML        = '<div style="text-align:center;padding:24px;color:#94a3b8;">Loading messages...</div>';

    // Mark active in list
    document.querySelectorAll('.session-item').forEach(el => el.classList.remove('active'));
    const activeItem = document.getElementById('session-item-' + id);
    if (activeItem) activeItem.classList.add('active');

    await loadMessages();

    // Start polling for this session
    if (pollingInterval) clearInterval(pollingInterval);
    pollingInterval = setInterval(pollNewMessages, 5000);
}

// ── Load all messages for selected session ────────────────────────────────────
async function loadMessages() {
    if (!currentSessionId) return;
    const res  = await fetch(`/admin/chat/api/messages/${currentSessionId}`);
    const data = await res.json();
    const msgs = Array.isArray(data) ? data : (data.messages ?? []);

    const container = document.getElementById('chat-messages');
    container.innerHTML = msgs.map(renderMessage).join('');
    if (msgs.length > 0) lastMessageId = msgs[msgs.length-1].id ?? 0;
    container.scrollTop = container.scrollHeight;
}

// ── Poll for new messages ──────────────────────────────────────────────────────
async function pollNewMessages() {
    if (!currentSessionId) return;
    try {
        const res  = await fetch(`/admin/chat/api/poll/${currentSessionId}?last_id=${lastMessageId}`);
        const data = await res.json();

        if (data.messages && data.messages.length > 0) {
            const container = document.getElementById('chat-messages');
            data.messages.forEach(m => {
                container.innerHTML += renderMessage(m);
                lastMessageId = m.id;
            });
            container.scrollTop = container.scrollHeight;
        }
        if (data.status) updateStatusUI(data.status, data.tiket_id);
    } catch(e) { /* silent */ }
}

function renderMessage(m) {
    const cls     = m.sender === 'pengunjung' ? 'msg-visitor' : m.sender === 'agen' ? 'msg-agent' : 'msg-ai';
    const label   = m.sender === 'pengunjung' ? 'Customer' : m.sender === 'agen' ? 'You (Agent)' : 'AI';
    const isRight = m.sender === 'pengunjung';
    const time    = m.timestamp ? new Date(m.timestamp).toLocaleTimeString('en', {hour:'2-digit',minute:'2-digit'}) : '';
    return `
        <div style="display:flex;flex-direction:column;align-items:${isRight ? 'flex-end' : 'flex-start'};">
            <div class="msg-sender">${label}</div>
            <div class="msg-bubble ${cls}">${escHtml(m.message || m.pesan)}</div>
            ${time ? `<div style="font-size:10px;color:#cbd5e1;margin-top:3px;">${time}</div>` : ''}
        </div>`;
}

function updateStatusUI(status, tiketId) {
    const badge     = document.getElementById('chat-status-badge');
    const btnEsc    = document.getElementById('btn-escalate');
    const btnClose  = document.getElementById('btn-close');
    const inputArea = document.getElementById('chat-input-area');

    badge.textContent = STATUS_LABEL[status] || status.toUpperCase();
    badge.className   = `status-badge ${STATUS_CLASS[status] || 'status-aktif'}`;

    btnEsc.style.display   = (status === 'aktif')   ? '' : 'none';
    btnClose.style.display = (status === 'selesai') ? 'none' : '';
    inputArea.style.display = (status === 'selesai') ? 'none' : '';

    if (tiketId) {
        btnEsc.style.display = 'none';
        const existing = document.getElementById('ticket-ref');
        if (!existing) {
            const header = document.querySelector('.chat-header > div:last-child');
            const ref = document.createElement('a');
            ref.id   = 'ticket-ref';
            ref.href = `/admin/tiket/detail/${tiketId}`;
            ref.style = 'font-size:12px;color:#6366f1;font-weight:700;';
            ref.textContent = `#Ticket ${tiketId}`;
            header.appendChild(ref);
        }
    }
}

// ── Send admin reply ──────────────────────────────────────────────────────────
async function sendAdminReply() {
    const input = document.getElementById('reply-input');
    const msg   = input.value.trim();
    if (!msg || !currentSessionId) return;
    input.value = '';

    try {
        await fetch('/admin/chat/api/message', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ session_id: currentSessionId, message: msg }),
        });
        // Optimistic UI
        const container = document.getElementById('chat-messages');
        const time = new Date().toLocaleTimeString('en', {hour:'2-digit',minute:'2-digit'});
        container.innerHTML += `
            <div style="display:flex;flex-direction:column;align-items:flex-start;">
                <div class="msg-sender">You (Agent)</div>
                <div class="msg-bubble msg-agent">${escHtml(msg)}</div>
                <div style="font-size:10px;color:#cbd5e1;margin-top:3px;">${time}</div>
            </div>`;
        container.scrollTop = container.scrollHeight;
    } catch(e) { alert('Failed to send message.'); }
}

// ── Close session ─────────────────────────────────────────────────────────────
async function closeSession() {
    if (!currentSessionId || !confirm('Close this chat session?')) return;
    await fetch('/admin/chat/api/close', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ session_id: currentSessionId }),
    });
    updateStatusUI('selesai', null);
    loadSessions();
}

// ── Escalate to ticket ────────────────────────────────────────────────────────
async function escalateSession() {
    if (!currentSessionId || !confirm('Create a support ticket for this chat?')) return;
    const res  = await fetch('/admin/chat/api/escalate', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ session_id: currentSessionId }),
    });
    const data = await res.json();
    if (data.success) {
        updateStatusUI('eskalasi', data.tiket_id);
        await pollNewMessages();
    }
}

// ── Keyboard shortcut: Enter to send ─────────────────────────────────────────
document.addEventListener('keydown', e => {
    if (e.key === 'Enter' && !e.shiftKey && document.activeElement.id === 'reply-input') {
        e.preventDefault();
        sendAdminReply();
    }
});

function escHtml(str) {
    return String(str || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

// ── Quick actions from session list ──────────────────────────────────────────
async function quickClose(sessionId, event) {
    event.stopPropagation();
    if (!confirm('Close this chat session?')) return;
    await fetch('/admin/chat/api/close', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ session_id: sessionId }),
    });
    if (currentSessionId === sessionId) updateStatusUI('selesai', null);
    loadSessions();
}

async function quickEscalate(sessionId, event) {
    event.stopPropagation();
    if (!confirm('Create a support ticket for this session?')) return;
    const res  = await fetch('/admin/chat/api/escalate', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ session_id: sessionId }),
    });
    const data = await res.json();
    if (data.success) {
        if (currentSessionId === sessionId) updateStatusUI('eskalasi', data.tiket_id);
        loadSessions();
    }
}

async function quickDelete(sessionId, event) {
    event.stopPropagation();
    if (!confirm('Permanently delete this session and all its messages? This cannot be undone.')) return;
    await fetch(`/admin/chat/api/session/${sessionId}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
    });
    if (currentSessionId === sessionId) {
        currentSessionId = null;
        if (pollingInterval) clearInterval(pollingInterval);
        document.getElementById('chat-empty').style.display = '';
        document.getElementById('chat-active').style.display = 'none';
    }
    loadSessions();
}

// ── Boot ──────────────────────────────────────────────────────────────────────
loadSessions();
sessionsInterval = setInterval(loadSessions, 5000);
</script>
@endsection
