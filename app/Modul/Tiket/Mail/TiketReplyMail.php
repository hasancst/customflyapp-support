<?php

namespace App\Modul\Tiket\Mail;

use App\Modul\Tiket\Model\Tiket;
use App\Modul\Tiket\Model\TiketPesan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TiketReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $tiket;
    public $pesan;
    public $isForCustomer;

    /**
     * Create a new message instance.
     */
    public function __construct(Tiket $tiket, TiketPesan $pesan, ?bool $isForCustomer = null)
    {
        $this->tiket = $tiket;
        $this->pesan = $pesan;
        $this->isForCustomer = $isForCustomer !== null ? $isForCustomer : (bool)$pesan->is_admin;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $prefix = $this->isForCustomer ? 'Balasan Tim Support' : 'Balasan Baru dari Pelanggan';
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
            view: 'tiket::emails.tiket-reply',
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
