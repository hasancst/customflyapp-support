<?php

namespace App\Modul\Tiket\Mail;

use App\Modul\Tiket\Model\Tiket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TiketStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $tiket;
    public $statusLama;
    public $statusBaru;
    public $isForCustomer;

    /**
     * Create a new message instance.
     */
    public function __construct(Tiket $tiket, string $statusLama, string $statusBaru, bool $isForCustomer = true)
    {
        $this->tiket = $tiket;
        $this->statusLama = $statusLama;
        $this->statusBaru = $statusBaru;
        $this->isForCustomer = $isForCustomer;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "[#{$this->tiket->no_tiket}] Status Tiket Diperbarui: " . ucfirst($this->statusBaru) . " - {$this->tiket->judul}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'tiket::emails.tiket-status',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
