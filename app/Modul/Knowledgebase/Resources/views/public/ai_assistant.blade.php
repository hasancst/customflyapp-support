<!-- AI Assistant Widget Component -->
<div id="aiAssistant" style="position: fixed; bottom: 30px; right: 30px; z-index: 1000;">
    <button id="aiToggle" style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, var(--primary, #4e73df), #8b5cf6); color: #fff; border: none; box-shadow: 0 10px 30px rgba(78, 115, 223, 0.3); cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 24px; transition: all 0.3s; padding: 0;">
        <i class="fas fa-robot"></i>
    </button>
    
    <div id="aiChatBox" style="display: none; position: absolute; bottom: 80px; right: 0; width: 400px; height: 600px; background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(20px); border-radius: 25px; box-shadow: 0 20px 60px rgba(0,0,0,0.15); overflow: hidden; border: 1px solid rgba(255,255,255,0.18);">
        <!-- Header -->
        <div style="background: linear-gradient(135deg, var(--primary, #4e73df), #8b5cf6); padding: 25px; color: #fff; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3 style="margin: 0; font-size: 18px; color: #fff;">🤖 AI Assistant</h3>
                <small style="opacity: 0.9; color: #fff;">Tanyakan apa saja tentang KB kami</small>
            </div>
            <button type="button" id="closeAiChat" style="background: rgba(255,255,255,0.2); border: none; color: #fff; width: 30px; height: 30px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <!-- Chat Messages -->
        <div id="chatMessages" style="padding: 20px; height: 420px; overflow-y: auto;">
            <div class="ai-message" style="background: #f8fafc; padding: 15px; border-radius: 15px; margin-bottom: 15px; border-left: 4px solid var(--primary, #4e73df);">
                <p style="margin: 0; color: #2d3748; line-height: 1.6;">
                    👋 Halo! Saya AI Assistant. Saya bisa membantu Anda menemukan informasi dari Knowledge Base kami secara cepat. Silakan ajukan pertanyaan Anda!
                </p>
            </div>
        </div>
        
        <!-- Input Overlay for Loading -->
        <div id="aiLoadingOverlay" style="display: none; position: absolute; bottom: 0; left: 0; right: 0; padding: 10px; background: rgba(255,255,255,0.8); text-align: center; font-size: 12px; color: var(--primary, #4e73df);">
             Sedang berpikir...
        </div>

        <!-- Input -->
        <div style="padding: 20px; border-top: 1px solid #e2e8f0; background: #fff;">
            <form id="aiForm" style="display: flex; gap: 10px; margin: 0;">
                <input type="text" id="pertanyaanInput" placeholder="Ketik pertanyaan Anda..." required style="flex: 1; padding: 12px 15px; border: 1px solid #e2e8f0; border-radius: 15px; outline: none; font-size: 14px; background: #fff !important; color: #2d3748;" />
                <button type="submit" id="kirimBtn" style="background: var(--primary, #4e73df); color: #fff; border: none; padding: 12px 20px; border-radius: 15px; cursor: pointer; display: flex; align-items: center; justify-content: center; width: 50px;">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    #aiToggle:hover {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 15px 40px rgba(78, 115, 223, 0.4);
    }
    
    #chatMessages::-webkit-scrollbar {
        width: 6px;
    }
    #chatMessages::-webkit-scrollbar-track {
        background: transparent;
    }
    #chatMessages::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }
    
    .ai-message {
        animation: fadeInUpAi 0.3s ease-out;
        box-shadow: 0 2px 5px rgba(0,0,0,0.02);
    }
    
    .user-message {
        background: linear-gradient(135deg, var(--primary, #4e73df), #8b5cf6);
        color: #fff;
        padding: 15px;
        border-radius: 15px;
        margin-bottom: 15px;
        margin-left: 40px;
        animation: fadeInUpAi 0.3s ease-out;
        box-shadow: 0 4px 12px rgba(78, 115, 223, 0.2);
    }
    
    .user-message p {
        margin: 0;
        color: #fff !important;
        line-height: 1.6;
    }
    
    @keyframes fadeInUpAi {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .typing-indicator {
        display: inline-flex;
        gap: 4px;
        padding: 12px 15px;
        background: #f1f5f9;
        border-radius: 15px;
        margin-bottom: 15px;
    }
    
    .typing-indicator span {
        width: 6px;
        height: 6px;
        background: #94a3b8;
        border-radius: 50%;
        animation: typingAi 1.4s infinite;
    }
    
    .typing-indicator span:nth-child(2) {
        animation-delay: 0.2s;
    }
    
    .typing-indicator span:nth-child(3) {
        animation-delay: 0.4s;
    }
    
    @keyframes typingAi {
        0%, 60%, 100% {
            transform: translateY(0);
            opacity: 0.5;
        }
        30% {
            transform: translateY(-4px);
            opacity: 1;
        }
    }
    
    @media (max-width: 640px) {
        #aiChatBox {
            width: calc(100vw - 40px);
            right: -10px;
            height: 80vh;
        }
    }
</style>

<script>
(function() {
    const aiToggle = document.getElementById('aiToggle');
    const aiChatBox = document.getElementById('aiChatBox');
    const closeAiChat = document.getElementById('closeAiChat');
    const aiForm = document.getElementById('aiForm');
    const pertanyaanInput = document.getElementById('pertanyaanInput');
    const chatMessages = document.getElementById('chatMessages');
    const kirimBtn = document.getElementById('kirimBtn');

    function toggleBox() {
        const isHidden = aiChatBox.style.display === 'none';
        aiChatBox.style.display = isHidden ? 'block' : 'none';
        if (isHidden) {
            pertanyaanInput.focus();
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    }

    aiToggle.addEventListener('click', toggleBox);
    closeAiChat.addEventListener('click', (e) => {
        e.stopPropagation();
        aiChatBox.style.display = 'none';
    });

    aiForm.addEventListener('submit', async function(event) {
        event.preventDefault();
        
        const pertanyaan = pertanyaanInput.value.trim();
        if (!pertanyaan) return;
        
        // Add user message
        const userMsg = document.createElement('div');
        userMsg.className = 'user-message';
        userMsg.innerHTML = `<p>${pertanyaan}</p>`;
        chatMessages.appendChild(userMsg);
        
        // Add typing indicator
        const typingDiv = document.createElement('div');
        typingDiv.className = 'typing-indicator';
        typingDiv.innerHTML = '<span></span><span></span><span></span>';
        chatMessages.appendChild(typingDiv);
        
        // Scroll to bottom
        chatMessages.scrollTop = chatMessages.scrollHeight;
        
        // Clear input and disable
        pertanyaanInput.value = '';
        pertanyaanInput.disabled = true;
        kirimBtn.disabled = true;
        kirimBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        
        try {
            const response = await fetch('/kb/ai-assistant', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({ pertanyaan })
            });
            
            const result = await response.json();
            
            // Remove typing indicator
            typingDiv.remove();
            
            if (result.berhasil) {
                // Add AI response
                const aiMsg = document.createElement('div');
                aiMsg.className = 'ai-message';
                aiMsg.style.cssText = 'background: #f8fafc; padding: 15px; border-radius: 15px; margin-bottom: 15px; border-left: 4px solid var(--primary, #4e73df);';
                aiMsg.innerHTML = `<div style="color: #2d3748; line-height: 1.6; font-size: 14px;">${result.data.jawaban}</div>`;
                
                if (result.data.artikel_relevan && result.data.artikel_relevan.length > 0) {
                    aiMsg.innerHTML += '<div style="margin-top: 12px; padding-top: 10px; border-top: 1px solid #e2e8f0;"><strong style="font-size: 12px; color: #64748b; text-transform: uppercase;">📚 Artikel Terkait:</strong><ul style="margin: 8px 0 0 0; padding-left: 20px;">';
                    result.data.artikel_relevan.forEach(artikel => {
                        aiMsg.innerHTML += `<li style="margin: 5px 0;"><a href="${artikel.url}" style="color: var(--primary, #4e73df); text-decoration: none; font-weight: 600;" target="_blank">${artikel.judul}</a></li>`;
                    });
                    aiMsg.innerHTML += '</ul></div>';
                }
                
                chatMessages.appendChild(aiMsg);
            } else {
                const errorMsg = document.createElement('div');
                errorMsg.className = 'ai-message';
                errorMsg.style.cssText = 'background: #fef2f2; padding: 15px; border-radius: 15px; margin-bottom: 15px; border: 1px solid #fecaca;';
                errorMsg.innerHTML = `<p style="margin: 0; color: #dc2626; font-size: 14px;">❌ ${result.pesan}</p>`;
                chatMessages.appendChild(errorMsg);
            }
        } catch (error) {
            if (typingDiv) typingDiv.remove();
            const errorMsg = document.createElement('div');
            errorMsg.className = 'ai-message';
            errorMsg.style.cssText = 'background: #fef2f2; padding: 15px; border-radius: 15px; margin-bottom: 15px;';
            errorMsg.innerHTML = `<p style="margin: 0; color: #dc2626; font-size: 14px;">❌ Terjadi kesalahan koneksi atau timeout.</p>`;
            chatMessages.appendChild(errorMsg);
        } finally {
            pertanyaanInput.disabled = false;
            kirimBtn.disabled = false;
            kirimBtn.innerHTML = '<i class="fas fa-paper-plane"></i>';
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    });
})();
</script>
