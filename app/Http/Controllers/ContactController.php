<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageForwarded;
use App\Models\ContactMessage;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|min:10',
        ]);

        $contactMessage = ContactMessage::create($validated);

        $this->forwardMessageToCompanyEmail($contactMessage);

        return redirect()->route('contact')
            ->with('success', 'Thank you for your message. We will get back to you soon!');
    }

    /**
     * Teruskan pesan kontak ke alamat email perusahaan jika fitur forward diaktifkan.
     */
    private function forwardMessageToCompanyEmail(ContactMessage $contactMessage): void
    {
        if (!SiteSetting::isContactForwardEnabled()) {
            return;
        }

        $recipients = SiteSetting::getContactForwardEmails();

        if ($recipients === []) {
            return;
        }

        try {
            Mail::to($recipients)->send(new ContactMessageForwarded($contactMessage));
        } catch (\Throwable $e) {
            // Simpan pesan tidak boleh gagal meskipun koneksi SMTP bermasalah
            Log::error('Gagal meneruskan pesan kontak ke email perusahaan.', [
                'contact_message_id' => $contactMessage->id,
                'recipients' => $recipients,
                'error' => $e->getMessage(),
            ]);
        }
    }
}