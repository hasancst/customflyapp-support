#!/usr/bin/env php
<?php

/**
 * Script Test Email Notifikasi Tiket
 * 
 * Usage: php test_email_tiket.php
 */

// Bootstrap Laravel
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Modul\Tiket\Model\Tiket;
use App\Modul\Tiket\Model\TiketPesan;
use App\Modul\Tiket\Services\TiketNotificationService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

echo "\n";
echo "═══════════════════════════════════════════════════════════════\n";
echo "  Test Email Notifikasi Tiket                                  \n";
echo "═══════════════════════════════════════════════════════════════\n\n";

// Cek koneksi database
try {
    DB::connection()->getPdo();
    echo "✅ Database: Terkoneksi\n\n";
} catch (\Exception $e) {
    echo "❌ Error: Tidak dapat terhubung ke database.\n";
    echo "   Detail: " . $e->getMessage() . "\n\n";
    exit(1);
}

// Tampilkan konfigurasi saat ini
echo "─────────────────────────────────────────────────────────────────\n";
echo "KONFIGURASI SAAT INI:\n";
echo "─────────────────────────────────────────────────────────────────\n\n";

$settings = DB::table('pengaturan')
    ->whereIn('kunci', [
        'mail_driver', 'mail_host', 'mail_port', 
        'mail_username', 'mail_from_address', 'mail_from_name',
        'tiket_notif_emails', 'email_admin'
    ])
    ->pluck('nilai', 'kunci');

echo "Mail Driver     : " . ($settings['mail_driver'] ?? 'tidak diset') . "\n";
echo "Mail Host       : " . ($settings['mail_host'] ?? 'tidak diset') . "\n";
echo "Mail Port       : " . ($settings['mail_port'] ?? 'tidak diset') . "\n";
echo "Mail Username   : " . ($settings['mail_username'] ?? 'tidak diset') . "\n";
echo "From Address    : " . ($settings['mail_from_address'] ?? 'tidak diset') . "\n";
echo "From Name       : " . ($settings['mail_from_name'] ?? 'tidak diset') . "\n";
echo "\n";
echo "Email Admin     : " . ($settings['email_admin'] ?? 'tidak diset') . "\n";
echo "Notif Tiket     : " . ($settings['tiket_notif_emails'] ?? 'tidak diset') . "\n";
echo "\n";

// Validasi konfigurasi
$hasMailConfig = !empty($settings['mail_host']) && !empty($settings['mail_username']);
$hasNotifEmails = !empty($settings['tiket_notif_emails']) || !empty($settings['email_admin']);

if (!$hasMailConfig) {
    echo "⚠️  WARNING: Konfigurasi SMTP belum lengkap!\n";
    echo "   Silakan isi konfigurasi di Admin → Settings → tab Konfigurasi Email\n\n";
}

if (!$hasNotifEmails) {
    echo "⚠️  WARNING: Email admin untuk notifikasi belum diisi!\n";
    echo "   Silakan isi 'Email Admin untuk Notifikasi Tiket' di Settings\n\n";
}

if (!$hasMailConfig || !$hasNotifEmails) {
    echo "❌ Tidak dapat melanjutkan test. Lengkapi konfigurasi terlebih dahulu.\n\n";
    exit(1);
}

// Menu Test
echo "═══════════════════════════════════════════════════════════════\n";
echo "PILIH JENIS TEST:\n";
echo "═══════════════════════════════════════════════════════════════\n\n";
echo "1. Test Email Sederhana (Raw Email)\n";
echo "2. Test Notifikasi Tiket Baru (Kirim Tiket)\n";
echo "3. Test Notifikasi Reply Tiket (Terima/Balas Tiket)\n";
echo "4. Test Notifikasi Update Status Tiket\n";
echo "5. Lihat Daftar Tiket\n";
echo "6. Keluar\n\n";

echo "Pilih (1-6): ";
$handle = fopen("php://stdin", "r");
$choice = trim(fgets($handle));

switch ($choice) {
    case '1':
        testRawEmail($settings);
        break;
    case '2':
        testNewTicketNotification();
        break;
    case '3':
        testReplyNotification();
        break;
    case '4':
        testStatusChangeNotification();
        break;
    case '5':
        showTicketList();
        break;
    case '6':
        echo "\nBye! 👋\n\n";
        exit(0);
    default:
        echo "\n❌ Pilihan tidak valid.\n\n";
        exit(1);
}

fclose($handle);

/**
 * Test 1: Email sederhana
 */
function testRawEmail($settings)
{
    echo "\n─────────────────────────────────────────────────────────────────\n";
    echo "TEST 1: KIRIM EMAIL SEDERHANA\n";
    echo "─────────────────────────────────────────────────────────────────\n\n";
    
    $email = $settings['tiket_notif_emails'] ?? $settings['email_admin'] ?? '';
    $emails = array_map('trim', explode(',', $email));
    $toEmail = $emails[0] ?? '';
    
    if (empty($toEmail)) {
        echo "❌ Email tujuan tidak ditemukan.\n\n";
        return;
    }
    
    echo "Kirim test email ke: $toEmail\n";
    echo "Mengirim...\n\n";
    
    try {
        Mail::raw('Ini adalah test email dari sistem tiket. Jika Anda menerima email ini, konfigurasi SMTP sudah benar! ✅', function($message) use ($toEmail) {
            $message->to($toEmail)
                    ->subject('Test Email dari Sistem Tiket');
        });
        
        echo "✅ Email berhasil dikirim!\n";
        echo "   Cek inbox Anda di: $toEmail\n";
        echo "   (Cek juga folder spam jika tidak ada)\n\n";
        
    } catch (\Exception $e) {
        echo "❌ Gagal mengirim email!\n";
        echo "   Error: " . $e->getMessage() . "\n\n";
        echo "   Troubleshooting:\n";
        echo "   1. Cek username dan password SMTP\n";
        echo "   2. Pastikan port dan enkripsi benar\n";
        echo "   3. Untuk Gmail, gunakan App Password\n";
        echo "   4. Cek firewall tidak block port " . ($settings['mail_port'] ?? '587') . "\n\n";
    }
}

/**
 * Test 2: Notifikasi tiket baru
 */
function testNewTicketNotification()
{
    echo "\n─────────────────────────────────────────────────────────────────\n";
    echo "TEST 2: NOTIFIKASI TIKET BARU\n";
    echo "─────────────────────────────────────────────────────────────────\n\n";
    
    echo "Membuat tiket test...\n";
    
    try {
        // Buat tiket dummy
        $noTiket = 'TEST-' . strtoupper(substr(uniqid(), -6));
        
        $tiket = Tiket::create([
            'no_tiket' => $noTiket,
            'judul' => 'Test Email Notifikasi - ' . date('d/m/Y H:i:s'),
            'email' => 'customer-test@example.com',
            'nama' => 'Customer Test',
            'shop_id' => 'test-shop.myshopify.com',
            'pesan_awal' => 'Ini adalah tiket test untuk menguji email notifikasi. Silakan abaikan tiket ini.',
            'prioritas' => 'tinggi',
            'status' => 'terbuka',
            'category_id' => null,
        ]);
        
        echo "✅ Tiket dibuat: {$tiket->no_tiket}\n";
        echo "   ID: {$tiket->id}\n\n";
        
        // Kirim notifikasi
        echo "Mengirim email notifikasi...\n";
        $notificationService = new TiketNotificationService();
        $notificationService->notifyNewTicket($tiket);
        
        echo "\n✅ Proses selesai!\n";
        echo "   Cek inbox admin Anda\n";
        echo "   Cek log: tail -f storage/logs/laravel.log | grep -i tiket\n\n";
        
        echo "💡 Tip: Anda bisa hapus tiket test ini di /admin/tiket\n\n";
        
    } catch (\Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "\n\n";
    }
}

/**
 * Test 3: Notifikasi reply
 */
function testReplyNotification()
{
    echo "\n─────────────────────────────────────────────────────────────────\n";
    echo "TEST 3: NOTIFIKASI REPLY TIKET\n";
    echo "─────────────────────────────────────────────────────────────────\n\n";
    
    // Cari tiket yang ada
    $tiket = Tiket::orderBy('created_at', 'desc')->first();
    
    if (!$tiket) {
        echo "❌ Tidak ada tiket yang tersedia.\n";
        echo "   Buat tiket dulu di admin panel atau jalankan Test 2.\n\n";
        return;
    }
    
    echo "Menggunakan tiket: {$tiket->no_tiket}\n";
    echo "Judul: {$tiket->judul}\n\n";
    
    try {
        // Buat pesan reply dari customer
        $pesan = TiketPesan::create([
            'tiket_id' => $tiket->id,
            'nama_pengirim' => 'Customer Test',
            'pesan' => 'Ini adalah test balasan dari customer untuk menguji email notifikasi.',
            'is_admin' => false,
        ]);
        
        echo "✅ Pesan reply dibuat\n\n";
        
        // Kirim notifikasi
        echo "Mengirim email notifikasi...\n";
        $notificationService = new TiketNotificationService();
        $notificationService->notifyTicketReply($tiket, $pesan);
        
        echo "\n✅ Proses selesai!\n";
        echo "   Cek inbox admin Anda\n";
        echo "   Cek log: tail -f storage/logs/laravel.log | grep -i tiket\n\n";
        
    } catch (\Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "\n\n";
    }
}

/**
 * Test 4: Notifikasi update status
 */
function testStatusChangeNotification()
{
    echo "\n─────────────────────────────────────────────────────────────────\n";
    echo "TEST 4: NOTIFIKASI PERUBAHAN STATUS TIKET\n";
    echo "─────────────────────────────────────────────────────────────────\n\n";
    
    $tiket = Tiket::orderBy('created_at', 'desc')->first();
    
    if (!$tiket) {
        echo "❌ Tidak ada tiket yang tersedia.\n\n";
        return;
    }
    
    $statusLama = $tiket->status;
    $statusBaru = ($statusLama === 'proses') ? 'selesai' : 'proses';
    
    echo "Menggunakan tiket: {$tiket->no_tiket}\n";
    echo "Simulasi perubahan status: {$statusLama} -> {$statusBaru}\n\n";
    
    try {
        echo "Mengirim email notifikasi status update ke pelanggan & admin...\n";
        $notificationService = new TiketNotificationService();
        $notificationService->notifyStatusChange($tiket, $statusLama, $statusBaru);
        
        echo "\n✅ Proses selesai!\n";
        echo "   Cek inbox pelanggan ({$tiket->email}) dan inbox admin Anda\n\n";
        
    } catch (\Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "\n\n";
    }
}

/**
 * Show ticket list
 */
function showTicketList()
{
    echo "\n─────────────────────────────────────────────────────────────────\n";
    echo "DAFTAR TIKET (10 TERBARU)\n";
    echo "─────────────────────────────────────────────────────────────────\n\n";
    
    $tikets = Tiket::orderBy('created_at', 'desc')->limit(10)->get();
    
    if ($tikets->isEmpty()) {
        echo "Tidak ada tiket.\n\n";
        return;
    }
    
    foreach ($tikets as $tiket) {
        echo "ID: {$tiket->id} | {$tiket->no_tiket} | {$tiket->status}\n";
        echo "   {$tiket->judul}\n";
        echo "   {$tiket->email} | " . $tiket->created_at->format('d/m/Y H:i') . "\n\n";
    }
}

echo "═══════════════════════════════════════════════════════════════\n\n";
