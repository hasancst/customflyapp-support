<?php

namespace App\Modul\Tiket\Mail;

use App\Modul\Tiket\Model\Tiket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TiketBaruMail extends Mailable
{
    use Queueable, SerializesModels;

    public $tiket;
    public $isForCustomer;

    /**
     * Create a new message instance.
     */
    public function __construct(Tiket $tiket, bool $isForCustomer = false)
    {
        $this->tiket = $tiket;
        $this->isForCustomer = $isForCustomer;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $prefix = $this->isForCustomer ? 'Tiket Diterima' : 'Tiket Baru Masuk';
        return new Envelope(
            subject: "[#{$this->tiket->no_tiket}] {$prefix}: {$this->tiket->judul}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'tiket::emails.tiket-baru',
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
