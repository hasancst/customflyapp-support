/**
 * AI-Powered Chat Widget
 * Embeddable chat widget with Knowledge Base integration
 */

(function () {
    'use strict';

    const ChatWidget = {
        config: {
            apiUrl: '',
            widgetKey: '',
            sessionToken: null,
            isOpen: false,
            isMinimized: false
        },

        init() {
            const script = document.currentScript;
            this.config.apiUrl = script.getAttribute('data-api');
            this.config.widgetKey = script.getAttribute('data-key');

            if (!this.config.apiUrl || !this.config.widgetKey) {
                console.error('Chat Widget: Missing required attributes');
                return;
            }

            this.loadSessionFromStorage();
            this.createWidget();
            this.attachEventListeners();
        },

        loadSessionFromStorage() {
            const stored = localStorage.getItem('chat_session_token');
            if (stored) {
                this.config.sessionToken = stored;
            }
        },

        createWidget() {
            const widgetHTML = `
                <div id="chat-widget-container" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                    <!-- Chat Button -->
                    <button id="chat-toggle-btn" style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.15); cursor: pointer; display: flex; align-items: center; justify-content: center; transition: transform 0.3s;">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                    </button>

                    <!-- Chat Window -->
                    <div id="chat-window" style="display: none; width: 380px; height: 600px; background: white; border-radius: 16px; box-shadow: 0 8px 32px rgba(0,0,0,0.12); overflow: hidden; flex-direction: column; position: absolute; bottom: 80px; right: 0;">
                        <!-- Header -->
                        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <h3 style="margin: 0; font-size: 18px; font-weight: 600;">Chat Support</h3>
                                <p style="margin: 4px 0 0 0; font-size: 13px; opacity: 0.9;">Kami siap membantu Anda</p>
                            </div>
                            <button id="chat-close-btn" style="background: rgba(255,255,255,0.2); border: none; color: white; width: 32px; height: 32px; border-radius: 50%; cursor: pointer; font-size: 18px;">×</button>
                        </div>

                        <!-- Messages -->
                        <div id="chat-messages" style="flex: 1; overflow-y: auto; padding: 20px; background: #f8f9fa;"></div>

                        <!-- Input -->
                        <div style="padding: 16px; background: white; border-top: 1px solid #e9ecef;">
                            <div style="display: flex; gap: 8px;">
                                <input id="chat-input" type="text" placeholder="Ketik pesan Anda..." style="flex: 1; padding: 12px; border: 1px solid #dee2e6; border-radius: 24px; outline: none; font-size: 14px;">
                                <button id="chat-send-btn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; width: 44px; height: 44px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="22" y1="2" x2="11" y2="13"></line>
                                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            document.body.insertAdjacentHTML('beforeend', widgetHTML);
        },

        attachEventListeners() {
            const toggleBtn = document.getElementById('chat-toggle-btn');
            const closeBtn = document.getElementById('chat-close-btn');
            const sendBtn = document.getElementById('chat-send-btn');
            const input = document.getElementById('chat-input');

            toggleBtn.addEventListener('click', () => this.toggleChat());
            closeBtn.addEventListener('click', () => this.closeChat());
            sendBtn.addEventListener('click', () => this.sendMessage());
            input.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') this.sendMessage();
            });
        },

        async toggleChat() {
            const chatWindow = document.getElementById('chat-window');

            if (this.config.isOpen) {
                this.closeChat();
            } else {
                chatWindow.style.display = 'flex';
                this.config.isOpen = true;

                if (!this.config.sessionToken) {
                    await this.initSession();
                } else {
                    await this.loadHistory();
                }
            }
        },

        closeChat() {
            document.getElementById('chat-window').style.display = 'none';
            this.config.isOpen = false;
        },

        async initSession() {
            try {
                const response = await fetch(`${this.config.apiUrl}/init`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        widget_key: this.config.widgetKey,
                        page_url: window.location.href
                    })
                });

                const data = await response.json();
                this.config.sessionToken = data.session_token;
                localStorage.setItem('chat_session_token', data.session_token);

                await this.loadHistory();
            } catch (error) {
                console.error('Failed to init chat:', error);
                this.addMessage('ai', 'Maaf, terjadi kesalahan. Silakan coba lagi.');
            }
        },

        async loadHistory() {
            try {
                const response = await fetch(`${this.config.apiUrl}/history/${this.config.sessionToken}`);
                const data = await response.json();

                const messagesContainer = document.getElementById('chat-messages');
                messagesContainer.innerHTML = '';

                data.messages.forEach(msg => {
                    this.addMessage(msg.sender, msg.message, false);
                });
            } catch (error) {
                console.error('Failed to load history:', error);
            }
        },

        async sendMessage() {
            const input = document.getElementById('chat-input');
            const message = input.value.trim();

            if (!message) return;

            this.addMessage('pengunjung', message);
            input.value = '';

            try {
                const response = await fetch(`${this.config.apiUrl}/message`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        session_token: this.config.sessionToken,
                        message: message
                    })
                });

                const data = await response.json();

                if (data.escalated) {
                    this.addMessage('ai', data.message);
                    this.showEscalationNotice(data.ticket_id);
                } else {
                    this.addMessage('ai', data.message);
                }
            } catch (error) {
                console.error('Failed to send message:', error);
                this.addMessage('ai', 'Maaf, terjadi kesalahan. Silakan coba lagi.');
            }
        },

        addMessage(sender, text, scroll = true) {
            const messagesContainer = document.getElementById('chat-messages');
            const isAI = sender === 'ai';

            const messageHTML = `
                <div style="display: flex; justify-content: ${isAI ? 'flex-start' : 'flex-end'}; margin-bottom: 12px;">
                    <div style="max-width: 75%; padding: 12px 16px; border-radius: 16px; background: ${isAI ? '#e9ecef' : 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)'}; color: ${isAI ? '#212529' : 'white'}; font-size: 14px; line-height: 1.5; white-space: pre-wrap;">
                        ${this.escapeHtml(text)}
                    </div>
                </div>
            `;

            messagesContainer.insertAdjacentHTML('beforeend', messageHTML);

            if (scroll) {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
        },

        showEscalationNotice(ticketId) {
            const notice = `
                <div style="background: #fff3cd; border: 1px solid #ffc107; border-radius: 8px; padding: 12px; margin: 12px 0; text-align: center; font-size: 13px;">
                    <strong>✅ Tiket #${ticketId} telah dibuat</strong><br>
                    Tim support kami akan menghubungi Anda segera.
                </div>
            `;
            document.getElementById('chat-messages').insertAdjacentHTML('beforeend', notice);
        },

        escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    };

    // Auto-initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => ChatWidget.init());
    } else {
        ChatWidget.init();
    }
})();
