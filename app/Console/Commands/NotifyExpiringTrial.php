<?php

namespace App\Console\Commands;

use App\Models\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class NotifyExpiringTrial extends Command
{
    protected $signature   = 'trial:notify-expiring';
    protected $description = 'Kirim email notifikasi ke client yang trial-nya berakhir dalam 3 hari';

    public function handle(): int
    {
        $now   = now();
        $from  = $now->copy()->addDays(2);  // >= 2 hari lagi
        $until = $now->copy()->addDays(3);  // < 3 hari lagi (window 24 jam)

        $clients = Client::where('trial_used', true)
            ->whereNotNull('trial_ends_at')
            ->whereBetween('trial_ends_at', [$from, $until])
            ->whereNull('trial_reminder_sent_at')
            ->get();

        $this->info("Ditemukan {$clients->count()} client yang perlu dinotifikasi.");

        foreach ($clients as $client) {
            try {
                Mail::send(
                    'emails.trial-expiring',
                    ['client' => $client],
                    function ($message) use ($client) {
                        $message->to($client->email, $client->name)
                                ->subject('Your Customfly trial ends in 3 days');
                    }
                );

                $client->update(['trial_reminder_sent_at' => now()]);

                $this->info("Email terkirim ke: {$client->email}");
            } catch (\Exception $e) {
                $this->error("Gagal kirim ke {$client->email}: " . $e->getMessage());
            }
        }

        return Command::SUCCESS;
    }
}
