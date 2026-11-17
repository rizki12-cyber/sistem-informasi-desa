<?php

namespace App\Mail;

use App\Models\Letter;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LetterReady extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Letter $letter,
        public string $pdfContent  // path file PDF yang sudah digenerate
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '✅ Surat Anda Siap Diambil - ' . $this->letter->letterType->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.letter-ready',
        );
    }

    public function attachments(): array
    {
        // Attach PDF file
        if (file_exists($this->pdfContent)) {
            return [
                \Illuminate\Mail\Mailables\Attachment::fromPath($this->pdfContent)
                    ->as('Surat-' . $this->letter->request_number . '.pdf')
                    ->withMime('application/pdf'),
            ];
        }
        return [];
    }
}