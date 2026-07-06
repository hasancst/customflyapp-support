# AI-Powered Chat Widget System - Documentation

## 📋 Overview

Sistem Chat Widget AI yang terintegrasi penuh dengan:
- **Knowledge Base** - Pencarian otomatis artikel KB
- **Ticketing System** - Auto-escalation ke tiket support
- **AI Confidence Scoring** - Penilaian kepercayaan jawaban AI

## 🏗️ Architecture

```
Chat Widget (JavaScript) 
    ↓ REST API
Laravel Backend
    ├── AIService (KB Search + Confidence Scoring)
    ├── TicketEscalationService (Auto Ticket Creation)
    └── ChatWidgetController (API Endpoints)
    ↓
Database (chat_widgets, chat_sessions, chat_messages)
```

## 🚀 Installation

### 1. Modul sudah terinstall ✅

Migrasi database telah dijalankan:
- `chat_widgets` - Multi-tenant widget configuration
- `chat_sessions` - Individual chat sessions
- `chat_messages` - All chat messages with AI metadata

### 2. Cara Menggunakan

#### A. Buat Widget Baru
1. Login ke admin panel
2. Buka menu **Chat Widget → Widgets**
3. Klik **"Buat Widget Baru"**
4. Isi nama widget (contoh: "Website Support")
5. Opsional: Isi domain yang diizinkan
6. Klik **"Buat Widget"**

#### B. Pasang di Website
1. Setelah widget dibuat, klik tombol **"Embed Code"**
2. Salin kode JavaScript yang muncul
3. Paste kode tersebut sebelum tag `</body>` di website Anda

Contoh embed code:
```html
<script src="https://rumahcyber.com/chat-widget.js"
  data-api="https://rumahcyber.com/api/chat"
  data-key="pk_xxxxxxxxxxxxxxxxxxxxx"></script>
```

## 🤖 AI Logic Flow

### 1. User mengirim pesan
```
User Message
    ↓
Extract Keywords (remove stopwords)
    ↓
Search Knowledge Base (title, content, tags)
    ↓
Calculate Relevance Score
    ↓
Calculate Confidence Score (0-1)
```

### 2. Decision Making

**High Confidence (≥ 0.65)**
- Kirim jawaban AI langsung
- Sertakan link ke artikel KB
- User tetap di chat

**Low Confidence (< 0.65)**
- Auto-escalate ke tiket
- Generate chat summary
- Create ticket dengan:
  - Judul dari pesan pertama
  - Deskripsi: AI summary + full transcript
  - Prioritas: Auto-detect dari keywords
  - Kategori: "Chat Escalation"

### 3. Manual Escalation Triggers

User akan otomatis di-escalate jika:
- Mengetik keyword: "human", "agent", "support", "manusia", "cs"
- Lebih dari 8 pesan tanpa resolusi
- Tidak ada aktivitas selama 10 menit
- Confidence score < 0.65

## 📊 Confidence Scoring Algorithm

```php
Base Score = (Matched Keywords / Total Keywords)

Boost Factors:
+ 0.2 if exact title match
+ High view count articles ranked higher

Final Score = min(1.0, Base Score + Boosts)

Threshold: 0.65
```

## 🎫 Auto Ticket Creation

Ketika chat di-escalate, sistem otomatis:

1. **Generate Summary**
   - Pesan pertama user
   - Total pesan dari user
   - Alasan escalation

2. **Format Transcript**
   ```
   [12:30] Pengunjung: Saya butuh bantuan
   [12:31] AI Assistant: Tentu, ada yang bisa saya bantu?
   [12:32] Pengunjung: Saya mau bicara dengan manusia
   ```

3. **Create Ticket**
   - Judul: "Chat: [60 karakter pertama pesan]"
   - Nama: Dari session atau "Anonymous"
   - Email: Dari session atau "no-email@chat.widget"
   - Prioritas: Auto-detect (tinggi/sedang/rendah)
   - Status: "terbuka"
   - Kategori: "Chat Escalation"

4. **Link Session**
   - Session status → "eskalasi"
   - Session.tiket_id → Ticket ID

## 🔒 Security Features

1. **Widget Authentication**
   - Public key validation
   - Domain whitelist (optional)
   - Session token (64 random chars)

2. **Rate Limiting**
   - Implementasi di middleware (recommended)
   - Prevent spam/abuse

3. **Input Sanitization**
   - Max message length: 1000 chars
   - HTML escaping di frontend
   - SQL injection protection (Eloquent ORM)

## 📱 Widget Features

### Frontend (JavaScript)
- ✅ Floating button (bottom-right)
- ✅ Responsive chat window (380x600px)
- ✅ Session persistence (localStorage)
- ✅ Real-time messaging
- ✅ Auto-scroll to latest message
- ✅ Escalation notice UI
- ✅ Typing indicator ready

### Backend (Laravel API)
- ✅ `/api/chat/init` - Initialize session
- ✅ `/api/chat/message` - Send message + AI response
- ✅ `/api/chat/history/{token}` - Load chat history
- ✅ `/api/chat/escalate` - Manual escalation
- ✅ `/api/chat/end` - End session

## 📈 Admin Dashboard

### Widgets Management (`/admin/chat`)
- List all widgets
- Create new widget
- View widget statistics
- Copy embed code
- Enable/disable widgets

### Sessions History (`/admin/chat/sessions`)
- View all chat sessions
- Filter by status (aktif/selesai/eskalasi)
- See linked tickets
- View full chat transcript

## 🔄 Integration Points

### With Knowledge Base
```php
AIService::searchKnowledgeBase($query)
- Searches: judul, konten, tags
- Orders by: views (popularity)
- Returns: Top 5 relevant articles
```

### With Ticketing System
```php
TicketEscalationService::escalateToTicket($session)
- Creates Tiket model
- Links session to ticket
- Sends email notification (if configured)
```

## 🎨 Customization

### Widget Appearance
Edit `pengaturan` JSON in `chat_widgets` table:
```json
{
  "theme_color": "#4e73df",
  "position": "bottom-right",
  "greeting": "Halo! Ada yang bisa kami bantu?"
}
```

### AI Confidence Threshold
Edit `AIService.php`:
```php
private const CONFIDENCE_THRESHOLD = 0.65; // Adjust this
```

### Auto-Escalation Timing
Edit `TicketEscalationService.php`:
```php
// Escalate after 10 minutes inactivity
if ($session->aktivitas_terakhir->diffInMinutes(now()) > 10)

// Escalate after 8 messages
if ($messageCount > 8)
```

## 🧪 Testing

### Test Chat Flow
1. Buka website dengan widget installed
2. Klik chat button
3. Kirim pesan: "Bagaimana cara reset password?"
4. AI akan search KB dan respond
5. Kirim: "Saya mau bicara dengan agent"
6. Chat auto-escalate ke tiket

### Test API Directly
```bash
# Init session
curl -X POST https://rumahcyber.com/api/chat/init \
  -H "Content-Type: application/json" \
  -d '{"widget_key":"pk_xxx","page_url":"https://test.com"}'

# Send message
curl -X POST https://rumahcyber.com/api/chat/message \
  -H "Content-Type: application/json" \
  -d '{"session_token":"xxx","message":"Hello"}'
```

## 📝 Database Schema

### chat_widgets
- id, nama, public_key, secret_key
- domain (whitelist), pengaturan (JSON)
- aktif, timestamps

### chat_sessions
- id, widget_id, session_token
- nama_pengunjung, email_pengunjung
- ip_pengunjung, user_agent, halaman_url
- status (aktif/selesai/eskalasi)
- tiket_id (FK to tikets)
- aktivitas_terakhir, timestamps

### chat_messages
- id, session_id
- pengirim (pengunjung/ai/agen)
- pesan (text)
- metadata (JSON: confidence, kb_articles)
- timestamps

## 🚨 Troubleshooting

### Widget tidak muncul
- Cek console browser untuk error
- Pastikan `data-api` dan `data-key` benar
- Cek CORS settings di Laravel

### AI tidak merespons
- Cek apakah Knowledge Base ada artikel
- Cek log Laravel: `storage/logs/laravel.log`
- Pastikan `kb_articles.published = true`

### Ticket tidak terbuat
- Cek foreign key constraint `tikets` table
- Pastikan Tiket model fillable fields
- Cek email validation

## 🎯 Next Steps / Enhancements

1. **Real-time dengan WebSocket**
   - Laravel Echo + Pusher
   - Live agent responses

2. **Analytics Dashboard**
   - Chat volume metrics
   - AI accuracy tracking
   - Popular KB articles

3. **Multi-language Support**
   - Detect user language
   - Translate AI responses

4. **File Upload**
   - Allow users to send images
   - Attach to tickets

5. **Canned Responses**
   - Quick replies for agents
   - Common questions library

## 📞 Support

Jika ada pertanyaan atau issue:
1. Cek dokumentasi ini
2. Review code di `app/Modul/Chat/`
3. Cek Laravel logs
4. Test API endpoints dengan Postman

---

**Status: ✅ PRODUCTION READY**

Sistem sudah siap digunakan. Buat widget pertama Anda di `/admin/chat`!
