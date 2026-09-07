<?php

namespace App\Modul\Tiket\Services;

use App\Modul\Tiket\Model\Tiket;
use App\Modul\Tiket\Model\TiketPesan;
use App\Modul\Tiket\Mail\TiketBaruMail;
use App\Modul\Tiket\Mail\TiketReplyMail;
use App\Modul\Tiket\Mail\TiketStatusMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class TiketNotificationService
{
    /**
     * Mendapatkan daftar email admin yang akan menerima notifikasi
     * 
     * @return array
     */
    protected function getAdminEmails(): array
    {
        // Ambil dari table pengaturan (kunci: tiket_notif_emails)
        try {
            $emailsSetting = DB::table('pengaturan')
                ->where('kunci', 'tiket_notif_emails')
                ->value('nilai');
            
            if (!empty($emailsSetting)) {
                $emails = array_map('trim', explode(',', $emailsSetting));
                $validEmails = array_filter($emails, fn($email) => filter_var($email, FILTER_VALIDATE_EMAIL));
                
                if (!empty($validEmails)) {
                    return array_values($validEmails);
                }
            }
        } catch (\Exception $e) {
            Log::debug('Tidak dapat membaca tiket_notif_emails dari pengaturan: ' . $e->getMessage());
        }

        // Fallback: gunakan email_admin dari pengaturan
        try {
            $emailAdmin = DB::table('pengaturan')
                ->where('kunci', 'email_admin')
                ->value('nilai');
            
            if (!empty($emailAdmin) && filter_var($emailAdmin, FILTER_VALIDATE_EMAIL)) {
                return [$emailAdmin];
            }
        } catch (\Exception $e) {
            Log::debug('Tidak dapat membaca email_admin dari pengaturan: ' . $e->getMessage());
        }

        return [];
    }

    /**
     * Kirim notifikasi email saat ada tiket baru (ke Admin & Pelanggan)
     * 
     * @param Tiket $tiket
     * @return void
     */
    public function notifyNewTicket(Tiket $tiket): void
    {
        try {
            // Load relasi yang diperlukan untuk email
            $tiket->loadMissing(['tiketKategori.parent']);

            // 1. Kirim notifikasi ke Admin
            $adminEmails = $this->getAdminEmails();
            if (!empty($adminEmails)) {
                foreach ($adminEmails as $adminEmail) {
                    try {
                        Mail::to($adminEmail)->send(new TiketBaruMail($tiket, false));
                    } catch (\Exception $e) {
                        Log::error('Gagal mengirim email tiket baru ke admin: ' . $adminEmail, ['error' => $e->getMessage()]);
                    }
                }
            } else {
                Log::warning('Tidak ada email admin yang dikonfigurasi untuk notifikasi tiket baru', [
                    'tiket_id' => $tiket->id,
                    'no_tiket' => $tiket->no_tiket,
                ]);
            }

            // 2. Kirim email konfirmasi tanda terima ke Pelanggan / Pembuat Tiket
            $customerEmail = trim($tiket->email ?? '');
            if (!empty($customerEmail) && filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
                try {
                    Mail::to($customerEmail)->send(new TiketBaruMail($tiket, true));
                } catch (\Exception $e) {
                    Log::error('Gagal mengirim email konfirmasi tiket baru ke pelanggan: ' . $customerEmail, ['error' => $e->getMessage()]);
                }
            }

            Log::info('Proses notifikasi email tiket baru selesai', [
                'tiket_id' => $tiket->id,
                'no_tiket' => $tiket->no_tiket,
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal memproses email notifikasi tiket baru', [
                'tiket_id' => $tiket->id,
                'no_tiket' => $tiket->no_tiket,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Kirim notifikasi email saat ada reply pada tiket:
     * - Jika balasan dari Admin -> kirim ke Pelanggan
     * - Jika balasan dari Pelanggan -> kirim ke Admin
     * 
     * @param Tiket $tiket
     * @param TiketPesan $pesan
     * @return void
     */
    public function notifyTicketReply(Tiket $tiket, TiketPesan $pesan): void
    {
        try {
            // Load relasi yang diperlukan untuk email
            $tiket->loadMissing(['tiketKategori.parent']);
            $pesan->loadMissing('user');

            if ($pesan->is_admin) {
                // Balasan dari Admin -> Kirim email ke Pelanggan
                $customerEmail = trim($tiket->email ?? '');
                if (!empty($customerEmail) && filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
                    Mail::to($customerEmail)->send(new TiketReplyMail($tiket, $pesan, true));
                    Log::info('Email balasan admin berhasil dikirim ke pelanggan', [
                        'tiket_id' => $tiket->id,
                        'customer_email' => $customerEmail,
                    ]);
                } else {
                    Log::warning('Email pelanggan tidak valid atau kosong untuk reply tiket', [
                        'tiket_id' => $tiket->id,
                    ]);
                }
            } else {
                // Balasan dari Pelanggan -> Kirim email ke semua Admin
                $adminEmails = $this->getAdminEmails();

                if (!empty($adminEmails)) {
                    foreach ($adminEmails as $adminEmail) {
                        try {
                            Mail::to($adminEmail)->send(new TiketReplyMail($tiket, $pesan, false));
                        } catch (\Exception $e) {
                            Log::error('Gagal mengirim email reply ke admin: ' . $adminEmail, ['error' => $e->getMessage()]);
                        }
                    }

                    Log::info('Email balasan pelanggan berhasil dikirim ke admin', [
                        'tiket_id' => $tiket->id,
                        'recipients' => count($adminEmails),
                    ]);
                } else {
                    Log::warning('Tidak ada email admin yang dikonfigurasi untuk notifikasi reply tiket', [
                        'tiket_id' => $tiket->id,
                    ]);
                }
            }

        } catch (\Exception $e) {
            Log::error('Gagal mengirim email notifikasi reply tiket', [
                'tiket_id' => $tiket->id,
                'no_tiket' => $tiket->no_tiket,
                'pesan_id' => $pesan->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Kirim notifikasi untuk perubahan status tiket (ke Pelanggan & Admin)
     * 
     * @param Tiket $tiket
     * @param string $statusLama
     * @param string $statusBaru
     * @return void
     */
    public function notifyStatusChange(Tiket $tiket, string $statusLama, string $statusBaru): void
    {
        if ($statusLama === $statusBaru) {
            return;
        }

        try {
            $tiket->loadMissing(['tiketKategori.parent']);

            // 1. Kirim notifikasi perubahan status ke Pelanggan
            $customerEmail = trim($tiket->email ?? '');
            if (!empty($customerEmail) && filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
                try {
                    Mail::to($customerEmail)->send(new TiketStatusMail($tiket, $statusLama, $statusBaru, true));
                } catch (\Exception $e) {
                    Log::error('Gagal mengirim status update tiket ke pelanggan: ' . $customerEmail, ['error' => $e->getMessage()]);
                }
            }

            // 2. Kirim notifikasi perubahan status ke Admin
            $adminEmails = $this->getAdminEmails();
            if (!empty($adminEmails)) {
                foreach ($adminEmails as $adminEmail) {
                    try {
                        Mail::to($adminEmail)->send(new TiketStatusMail($tiket, $statusLama, $statusBaru, false));
                    } catch (\Exception $e) {
                        Log::error('Gagal mengirim status update tiket ke admin: ' . $adminEmail, ['error' => $e->getMessage()]);
                    }
                }
            }

            Log::info('Notifikasi perubahan status tiket berhasil diproses', [
                'tiket_id' => $tiket->id,
                'status_lama' => $statusLama,
                'status_baru' => $statusBaru,
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal mengirim email perubahan status tiket', [
                'tiket_id' => $tiket->id,
                'no_tiket' => $tiket->no_tiket,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
