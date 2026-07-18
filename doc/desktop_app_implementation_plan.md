# iMakeCustom Desktop App — Implementation Plan

> **Keputusan final:**
> - **Framework:** Electron + React + Vite
> - **Auth:** Laravel Sanctum API Token
> - **Scope:** Support Tickets, Live Chat, Task Management, Content Management
> - **Target OS:** Linux (AppImage + .deb)

**Goal:** Aplikasi desktop Linux untuk manage Support Tickets, Live Chat, Task, dan Content dari imakecustom.com tanpa buka browser.

**Architecture:** Phase 1 — Setup Sanctum API di server Laravel. Phase 2 — Electron + React desktop app terhubung via Bearer Token ke API.

**Tech Stack:**
- Backend: Laravel 11 + Sanctum (server `imakecustom.com`)
- Desktop: Electron 31 + React 18 + Vite + Axios + electron-store

---

## PHASE 1 — Backend: Sanctum API (di server Laravel)

> Semua perubahan di `/www/wwwroot/imakecustom.com`

---

### Task 1.1: Install & Konfigurasi Sanctum

**Files:**
- Modify: `config/sanctum.php` (sudah ada di Laravel 11)
- Modify: `bootstrap/app.php` (enable Sanctum middleware)
- Modify: `app/Models/User.php` (tambah HasApiTokens)

- [ ] **Step 1: Publish Sanctum config**

```bash
cd /www/wwwroot/imakecustom.com
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

Expected: `config/sanctum.php` ter-publish.

- [ ] **Step 2: Tambahkan HasApiTokens ke User model**

Buka `app/Models/User.php`, pastikan ada:

```php
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // ...
}
```

- [ ] **Step 3: Jalankan migrasi Sanctum**

```bash
php artisan migrate
```

Expected: tabel `personal_access_tokens` dibuat.

- [ ] **Step 4: Verifikasi tabel ada**

```bash
php artisan tinker --execute="echo \DB::select(\"SHOW TABLES LIKE 'personal_access_tokens'\") ? 'OK' : 'GAGAL';"
```

Expected output: `OK`

- [ ] **Step 5: Commit**

```bash
git add . && git commit -m "feat: enable laravel sanctum for API token auth"
```

---

### Task 1.2: API Auth Endpoints (Login & Logout)

**Files:**
- Create: `app/Http/Controllers/Api/AuthApiController.php`
- Modify: `routes/api.php`

- [ ] **Step 1: Buat AuthApiController**

Buat file `app/Http/Controllers/Api/AuthApiController.php`:

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthApiController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah.',
            ], 401);
        }

        $user  = Auth::user();
        $token = $user->createToken('desktop-app')->plainTextToken;

        return response()->json([
            'success' => true,
            'token'   => $token,
            'user'    => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
            ],
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['success' => true, 'message' => 'Logged out.']);
    }

    public function me(Request $request)
    {
        return response()->json(['user' => $request->user()]);
    }
}
```

- [ ] **Step 2: Tambah routes di routes/api.php**

Buka `routes/api.php`, tambahkan:

```php
use App\Http\Controllers\Api\AuthApiController;

// Public auth routes
Route::post('/auth/login',  [AuthApiController::class, 'login']);

// Protected routes (require token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthApiController::class, 'logout']);
    Route::get('/auth/me',     [AuthApiController::class, 'me']);
});
```

- [ ] **Step 3: Test login via curl**

```bash
curl -X POST https://imakecustom.com/api/auth/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"email":"admin@imakecustom.com","password":"YOUR_PASSWORD"}'
```

Expected response:
```json
{
  "success": true,
  "token": "1|abcdefghij...",
  "user": { "id": 1, "name": "Admin", "email": "admin@..." }
}
```

- [ ] **Step 4: Test logout**

```bash
# Ganti TOKEN dengan token dari step 3
curl -X POST https://imakecustom.com/api/auth/logout \
  -H "Authorization: Bearer TOKEN" \
  -H "Accept: application/json"
```

Expected: `{"success": true}`

- [ ] **Step 5: Commit**

```bash
git add . && git commit -m "feat: API auth endpoints login/logout via Sanctum"
```

---

### Task 1.3: API Endpoints — Support Tickets

**Files:**
- Create: `app/Http/Controllers/Api/TiketApiController.php`
- Modify: `routes/api.php`

- [ ] **Step 1: Buat TiketApiController**

Buat `app/Http/Controllers/Api/TiketApiController.php`:

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modul\Tiket\Models\Tiket;
use App\Modul\Tiket\Models\TiketBalasan;
use Illuminate\Http\Request;

class TiketApiController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $query  = Tiket::with('kategori')->latest();

        if ($status) {
            $query->where('status', $status);
        }

        $tiket = $query->paginate(30);

        return response()->json(['success' => true, 'data' => $tiket]);
    }

    public function show($id)
    {
        $tiket = Tiket::with(['kategori', 'balasan'])->findOrFail($id);

        return response()->json(['success' => true, 'data' => $tiket]);
    }

    public function reply(Request $request, $id)
    {
        $request->validate(['pesan' => 'required|string']);

        $tiket = Tiket::findOrFail($id);

        $balasan = TiketBalasan::create([
            'tiket_id'   => $tiket->id,
            'pesan'      => $request->pesan,
            'dari_admin' => true,
            'user_id'    => $request->user()->id,
        ]);

        $tiket->update(['status' => 'answered']);

        return response()->json(['success' => true, 'data' => $balasan]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:open,answered,closed,pending']);

        $tiket = Tiket::findOrFail($id);
        $tiket->update(['status' => $request->status]);

        return response()->json(['success' => true, 'data' => $tiket]);
    }
}
```

- [ ] **Step 2: Tambah routes tiket ke api.php**

```php
use App\Http\Controllers\Api\TiketApiController;

Route::middleware('auth:sanctum')->group(function () {
    // ... existing routes ...

    // Tickets
    Route::get('/tickets',               [TiketApiController::class, 'index']);
    Route::get('/tickets/{id}',          [TiketApiController::class, 'show']);
    Route::post('/tickets/{id}/reply',   [TiketApiController::class, 'reply']);
    Route::patch('/tickets/{id}/status', [TiketApiController::class, 'updateStatus']);
});
```

- [ ] **Step 3: Test list tiket**

```bash
curl https://imakecustom.com/api/tickets \
  -H "Authorization: Bearer TOKEN" \
  -H "Accept: application/json"
```

Expected: JSON dengan list tiket.

- [ ] **Step 4: Test reply tiket (ganti ID dengan ID tiket yang ada)**

```bash
curl -X POST https://imakecustom.com/api/tickets/1/reply \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"pesan":"Test reply dari API"}'
```

Expected: `{"success": true, "data": {...}}`

- [ ] **Step 5: Commit**

```bash
git add . && git commit -m "feat: API endpoints for support tickets CRUD"
```

---

### Task 1.4: API Endpoints — Live Chat

**Files:**
- Create: `app/Http/Controllers/Api/ChatApiController.php`
- Modify: `routes/api.php`

- [ ] **Step 1: Cek model Chat yang sudah ada**

```bash
find /www/wwwroot/imakecustom.com/app/Modul/Chat -name "*.php" | head -20
```

- [ ] **Step 2: Buat ChatApiController**

Buat `app/Http/Controllers/Api/ChatApiController.php`:

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modul\Chat\Models\ChatSession;
use App\Modul\Chat\Models\ChatMessage;
use Illuminate\Http\Request;

class ChatApiController extends Controller
{
    public function activeSessions()
    {
        $sessions = ChatSession::where('status', 'aktif')
            ->with('latestMessage')
            ->orderByDesc('updated_at')
            ->get()
            ->map(function ($s) {
                return [
                    'id'              => $s->id,
                    'session_token'   => $s->session_token,
                    'nama_pengunjung' => $s->nama_pengunjung ?? 'Anonymous',
                    'status'          => $s->status,
                    'pesan_terakhir'  => $s->latestMessage?->pesan ?? '',
                    'updated_at'      => $s->updated_at->diffForHumans(),
                ];
            });

        return response()->json(['success' => true, 'data' => $sessions]);
    }

    public function messages($sessionId)
    {
        $session  = ChatSession::findOrFail($sessionId);
        $messages = ChatMessage::where('chat_session_id', $sessionId)
            ->orderBy('created_at')
            ->get();

        return response()->json(['success' => true, 'data' => $messages]);
    }

    public function sendMessage(Request $request, $sessionId)
    {
        $request->validate(['pesan' => 'required|string']);

        $session = ChatSession::findOrFail($sessionId);

        $message = ChatMessage::create([
            'chat_session_id' => $sessionId,
            'pesan'           => $request->pesan,
            'dari'            => 'admin',
        ]);

        $session->touch();

        return response()->json(['success' => true, 'data' => $message]);
    }

    public function closeSession($sessionId)
    {
        $session = ChatSession::findOrFail($sessionId);
        $session->update(['status' => 'selesai']);

        return response()->json(['success' => true]);
    }
}
```

- [ ] **Step 3: Tambah routes chat ke api.php**

```php
use App\Http\Controllers\Api\ChatApiController;

Route::middleware('auth:sanctum')->group(function () {
    // ... existing routes ...

    // Chat
    Route::get('/chat/sessions',              [ChatApiController::class, 'activeSessions']);
    Route::get('/chat/sessions/{id}/messages',[ChatApiController::class, 'messages']);
    Route::post('/chat/sessions/{id}/send',   [ChatApiController::class, 'sendMessage']);
    Route::post('/chat/sessions/{id}/close',  [ChatApiController::class, 'closeSession']);
});
```

- [ ] **Step 4: Test active sessions**

```bash
curl https://imakecustom.com/api/chat/sessions \
  -H "Authorization: Bearer TOKEN" \
  -H "Accept: application/json"
```

Expected: JSON list active sessions.

- [ ] **Step 5: Commit**

```bash
git add . && git commit -m "feat: API endpoints for live chat sessions and messages"
```

---

### Task 1.5: API Endpoints — Task Management

**Files:**
- Create: `app/Http/Controllers/Api/TaskApiController.php`
- Modify: `routes/api.php`

- [ ] **Step 1: Cek model Task**

```bash
find /www/wwwroot/imakecustom.com/app/Modul/Task -name "*.php" | head -20
```

- [ ] **Step 2: Buat TaskApiController**

Buat `app/Http/Controllers/Api/TaskApiController.php`:

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modul\Task\Models\Task;
use Illuminate\Http\Request;

class TaskApiController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $query  = Task::whereNull('parent_id')->with('children')->latest();

        if ($status) {
            $query->where('status', $status);
        }

        return response()->json(['success' => true, 'data' => $query->get()]);
    }

    public function show($uuid)
    {
        $task = Task::where('uuid', $uuid)->with('children', 'parent')->firstOrFail();

        return response()->json(['success' => true, 'data' => $task]);
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required|string|max:255']);

        $task = Task::create([
            'title'     => $request->title,
            'parent_id' => $request->parent_id,
            'priority'  => $request->priority ?? 'normal',
            'due_at'    => $request->due_at,
            'status'    => 'pending',
            'uuid'      => \Str::uuid(),
        ]);

        return response()->json(['success' => true, 'data' => $task], 201);
    }

    public function updateStatus(Request $request, $uuid)
    {
        $request->validate(['status' => 'required|in:pending,done,in_progress']);

        $task = Task::where('uuid', $uuid)->firstOrFail();
        $task->update(['status' => $request->status]);

        return response()->json(['success' => true, 'data' => $task]);
    }

    public function destroy($uuid)
    {
        $task = Task::where('uuid', $uuid)->firstOrFail();
        $task->delete();

        return response()->json(['success' => true]);
    }
}
```

- [ ] **Step 3: Tambah routes task ke api.php**

```php
use App\Http\Controllers\Api\TaskApiController;

Route::middleware('auth:sanctum')->group(function () {
    // ... existing routes ...

    // Tasks
    Route::get('/tasks',               [TaskApiController::class, 'index']);
    Route::post('/tasks',              [TaskApiController::class, 'store']);
    Route::get('/tasks/{uuid}',        [TaskApiController::class, 'show']);
    Route::patch('/tasks/{uuid}/status',[TaskApiController::class, 'updateStatus']);
    Route::delete('/tasks/{uuid}',     [TaskApiController::class, 'destroy']);
});
```

- [ ] **Step 4: Test list tasks**

```bash
curl https://imakecustom.com/api/tasks \
  -H "Authorization: Bearer TOKEN" \
  -H "Accept: application/json"
```

- [ ] **Step 5: Test create task**

```bash
curl -X POST https://imakecustom.com/api/tasks \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"title":"Test task dari API","priority":"normal"}'
```

- [ ] **Step 6: Commit**

```bash
git add . && git commit -m "feat: API endpoints for task management"
```

---

### Task 1.6: API Endpoints — Content Management (News & Articles)

**Files:**
- Create: `app/Http/Controllers/Api/ContentApiController.php`
- Modify: `routes/api.php`

- [ ] **Step 1: Cek model Berita**

```bash
find /www/wwwroot/imakecustom.com/app/Modul/Berita -name "*.php" | head -10
```

- [ ] **Step 2: Buat ContentApiController**

Buat `app/Http/Controllers/Api/ContentApiController.php`:

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modul\Berita\Models\Berita;
use Illuminate\Http\Request;

class ContentApiController extends Controller
{
    public function index(Request $request)
    {
        $berita = Berita::with('kategori')
            ->latest()
            ->paginate(20);

        return response()->json(['success' => true, 'data' => $berita]);
    }

    public function show($id)
    {
        $berita = Berita::with('kategori')->findOrFail($id);

        return response()->json(['success' => true, 'data' => $berita]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'        => 'required|string|max:255',
            'konten'       => 'required|string',
            'kategori_id'  => 'nullable|integer',
        ]);

        $berita = Berita::create([
            'judul'       => $request->judul,
            'konten'      => $request->konten,
            'kategori_id' => $request->kategori_id,
            'status'      => $request->status ?? 'draft',
            'slug'        => \Str::slug($request->judul),
        ]);

        return response()->json(['success' => true, 'data' => $berita], 201);
    }

    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);
        $berita->update($request->only(['judul', 'konten', 'kategori_id', 'status']));

        return response()->json(['success' => true, 'data' => $berita]);
    }

    public function destroy($id)
    {
        Berita::findOrFail($id)->delete();

        return response()->json(['success' => true]);
    }
}
```

- [ ] **Step 3: Tambah routes content ke api.php**

```php
use App\Http\Controllers\Api\ContentApiController;

Route::middleware('auth:sanctum')->group(function () {
    // ... existing routes ...

    // Content (News)
    Route::get('/content',        [ContentApiController::class, 'index']);
    Route::post('/content',       [ContentApiController::class, 'store']);
    Route::get('/content/{id}',   [ContentApiController::class, 'show']);
    Route::patch('/content/{id}', [ContentApiController::class, 'update']);
    Route::delete('/content/{id}',[ContentApiController::class, 'destroy']);
});
```

- [ ] **Step 4: Test list content**

```bash
curl https://imakecustom.com/api/content \
  -H "Authorization: Bearer TOKEN" \
  -H "Accept: application/json"
```

- [ ] **Step 5: Commit**

```bash
git add . && git commit -m "feat: API endpoints for content management (news)"
```

---

### Task 1.7: Final — API Testing & Push

- [ ] **Step 1: Jalankan semua test endpoint sekaligus**

```bash
# Login dan simpan token
TOKEN=$(curl -s -X POST https://imakecustom.com/api/auth/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"email":"YOUR_EMAIL","password":"YOUR_PASS"}' | python3 -c "import sys,json; print(json.load(sys.stdin)['token'])")

echo "Token: $TOKEN"

# Test semua endpoints
curl -s https://imakecustom.com/api/tickets -H "Authorization: Bearer $TOKEN" -H "Accept: application/json" | python3 -c "import sys,json; d=json.load(sys.stdin); print('Tickets OK:', d['success'])"
curl -s https://imakecustom.com/api/chat/sessions -H "Authorization: Bearer $TOKEN" -H "Accept: application/json" | python3 -c "import sys,json; d=json.load(sys.stdin); print('Chat OK:', d['success'])"
curl -s https://imakecustom.com/api/tasks -H "Authorization: Bearer $TOKEN" -H "Accept: application/json" | python3 -c "import sys,json; d=json.load(sys.stdin); print('Tasks OK:', d['success'])"
curl -s https://imakecustom.com/api/content -H "Authorization: Bearer $TOKEN" -H "Accept: application/json" | python3 -c "import sys,json; d=json.load(sys.stdin); print('Content OK:', d['success'])"
```

Expected:
```
Token: 1|xxxx...
Tickets OK: True
Chat OK: True
Tasks OK: True
Content OK: True
```

- [ ] **Step 2: Push ke GitHub**

```bash
cd /www/wwwroot/imakecustom.com
git push origin main
```

---

## PHASE 2 — Desktop App (Electron + React)

> Dikerjakan setelah Phase 1 selesai dan semua API endpoint verified ✅

*(Plan akan diperinci setelah Phase 1 done)*

---

## Checklist Overview

### Phase 1 — Backend API

- [ ] Task 1.1 — Install & Konfigurasi Sanctum
- [ ] Task 1.2 — Auth Endpoints (Login/Logout)
- [ ] Task 1.3 — Tickets API
- [ ] Task 1.4 — Chat API
- [ ] Task 1.5 — Task Management API
- [ ] Task 1.6 — Content Management API
- [ ] Task 1.7 — Final Testing & Push

### Phase 2 — Desktop App

- [ ] Task 2.1 — Scaffold Electron + React + Vite
- [ ] Task 2.2 — Auth (Login, simpan token di electron-store)
- [ ] Task 2.3 — Tickets View
- [ ] Task 2.4 — Chat View (polling 10 detik)
- [ ] Task 2.5 — Task View
- [ ] Task 2.6 — Content View
- [ ] Task 2.7 — Sidebar + System Tray + Notifikasi
- [ ] Task 2.8 — Build & Package (AppImage + .deb)

---

> [!NOTE]
> Jangan mulai Phase 2 sebelum semua checklist Phase 1 berstatus ✅ dan semua endpoint test mengembalikan `success: true`.
