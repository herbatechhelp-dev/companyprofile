<?php

namespace App\Mail;

use App\Filament\Resources\ContactMessageResource;
use App\Models\ContactMessage;
use App\Models\SiteSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMessageForwarded extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Buat instance email penerusan pesan kontak baru.
     */
    public function __construct(
        public ContactMessage $contactMessage,
        public bool $isTest = false,
    ) {
    }

    /**
     * Konfigurasi pengirim balasan (reply-to) dan subjek email.
     */
    public function envelope(): Envelope
    {
        $companyName = SiteSetting::getCompanyName();
        $prefix = $this->isTest ? '[Uji Coba] ' : '';

        return new Envelope(
            replyTo: $this->contactMessage->email
                ? [new Address($this->contactMessage->email, $this->contactMessage->name)]
                : [],
            subject: "{$prefix}[Pesan Kontak] {$companyName} - {$this->contactMessage->name}",
        );
    }

    /**
     * Konten dan view template email.
     */
    public function content(): Content
    {
        $adminUrl = $this->contactMessage->exists
            ? ContactMessageResource::getUrl('edit', ['record' => $this->contactMessage], panel: 'admin')
            : ContactMessageResource::getUrl('index', panel: 'admin');

        return new Content(
            view: 'emails.contact-message-forwarded',
            with: [
                'companyName' => SiteSetting::getCompanyName(),
                'adminUrl' => $adminUrl,
                'isTest' => $this->isTest,
            ],
        );
    }
}
