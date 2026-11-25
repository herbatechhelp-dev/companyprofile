<?php

namespace Tests\Feature;

use App\Filament\Pages\ContactForwardSettings;
use App\Mail\ContactMessageForwarded;
use App\Models\ContactMessage;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class ContactForwardingTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        SiteSetting::flushCache();
    }

    protected function tearDown(): void
    {
        SiteSetting::flushCache();
        parent::tearDown();
    }

    public function test_contact_message_is_saved_and_forwarded_when_enabled(): void
    {
        Mail::fake();

        SiteSetting::setValue(SiteSetting::CONTACT_FORWARD_ENABLED_KEY, '1', 'text');
        SiteSetting::setValue(
            SiteSetting::CONTACT_FORWARD_EMAIL_KEY,
            'sales@company.com, cs@company.com',
            'text'
        );

        $response = $this->post(route('contact.store'), [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'message' => 'Halo, saya ingin menanyakan kerja sama maklon produk herbal.',
        ]);

        $response->assertRedirect(route('contact'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
        ]);

        Mail::assertSent(ContactMessageForwarded::class, function (ContactMessageForwarded $mail): bool {
            return $mail->hasTo('sales@company.com')
                && $mail->hasTo('cs@company.com')
                && $mail->hasReplyTo('budi@example.com')
                && !$mail->isTest;
        });
    }

    public function test_contact_message_is_saved_without_forwarding_when_disabled(): void
    {
        Mail::fake();

        SiteSetting::setValue(SiteSetting::CONTACT_FORWARD_ENABLED_KEY, '0', 'text');
        SiteSetting::setValue(SiteSetting::CONTACT_FORWARD_EMAIL_KEY, 'sales@company.com', 'text');

        $response = $this->post(route('contact.store'), [
            'name' => 'Siti Aminah',
            'email' => 'siti@example.com',
            'message' => 'Pesan ini harus tersimpan di database tanpa dikirim ke email.',
        ]);

        $response->assertRedirect(route('contact'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Siti Aminah',
            'email' => 'siti@example.com',
        ]);

        Mail::assertNothingSent();
    }

    public function test_contact_message_still_succeeds_if_mailer_throws_exception(): void
    {
        SiteSetting::setValue(SiteSetting::CONTACT_FORWARD_ENABLED_KEY, '1', 'text');
        SiteSetting::setValue(SiteSetting::CONTACT_FORWARD_EMAIL_KEY, 'sales@company.com', 'text');

        Mail::shouldReceive('to')
            ->once()
            ->with(['sales@company.com'])
            ->andThrow(new \RuntimeException('SMTP server unreachable'));

        $response = $this->post(route('contact.store'), [
            'name' => 'Andi Wijaya',
            'email' => 'andi@example.com',
            'message' => 'Menguji bahwa pesan tetap aman tersimpan saat SMTP error.',
        ]);

        $response->assertRedirect(route('contact'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Andi Wijaya',
            'email' => 'andi@example.com',
        ]);
    }

    public function test_contact_form_enforces_rate_limit(): void
    {
        Mail::fake();
        SiteSetting::setValue(SiteSetting::CONTACT_FORWARD_ENABLED_KEY, '0', 'text');

        for ($i = 0; $i < 5; $i++) {
            $this->post(route('contact.store'), [
                'name' => 'Rate Test ' . $i,
                'email' => 'rate@example.com',
                'message' => 'Pesan uji batas pengiriman ke ' . $i . ' pada form kontak.',
            ])->assertRedirect(route('contact'));
        }

        $this->post(route('contact.store'), [
            'name' => 'Rate Test Over',
            'email' => 'rate@example.com',
            'message' => 'Pesan keenam dalam satu menit harus ditolak limiter.',
        ])->assertStatus(429);
    }

    public function test_forwarded_mailable_renders_escaped_content_and_admin_link(): void
    {
        $contactMessage = ContactMessage::create([
            'name' => 'Rina Kusuma',
            'email' => 'rina@example.com',
            'message' => "Baris satu <script>alert(1)</script>\nBaris dua",
        ]);

        $mailable = new ContactMessageForwarded($contactMessage);
        $html = $mailable->render();

        $this->assertStringContainsString('Rina Kusuma', $html);
        $this->assertStringContainsString('rina@example.com', $html);
        $this->assertStringNotContainsString('<script>alert(1)</script>', $html);
        $this->assertStringContainsString('&lt;script&gt;alert(1)&lt;/script&gt;', $html);
        $this->assertStringContainsString('/admin/contact-messages/' . $contactMessage->id . '/edit', $html);
    }

    public function test_normalize_email_list_deduplicates_and_filters_invalid_emails(): void
    {
        $result = SiteSetting::normalizeEmailList(' Admin@Company.com , invalid-email, admin@company.com; cs@company.com ');

        $this->assertSame(['Admin@Company.com', 'cs@company.com'], $result);
    }

    public function test_guest_cannot_access_contact_forward_settings_page(): void
    {
        $this->get('/admin/contact-forward-settings')
            ->assertRedirect('/admin/login');
    }

    public function test_admin_can_view_pages_and_save_forward_email_settings(): void
    {
        Mail::fake();

        $admin = User::factory()->create();
        $this->actingAs($admin);

        $this->get('/admin/contact-forward-settings')
            ->assertOk()
            ->assertSee('Pengaturan Forward Email Pesan');

        $this->get('/admin/site-settings')
            ->assertOk()
            ->assertSee('Forward Email Pesan');

        $this->get('/admin/contact-messages')
            ->assertOk()
            ->assertSee('Pengaturan Forward Email');

        Livewire::test(ContactForwardSettings::class)
            ->fillForm([
                SiteSetting::CONTACT_FORWARD_ENABLED_KEY => true,
                SiteSetting::CONTACT_FORWARD_EMAIL_KEY => ['sales@company.com', 'cs@company.com'],
            ])
            ->call('save')
            ->assertHasNoFormErrors()
            ->call('sendTestEmail');

        $this->assertTrue(SiteSetting::isContactForwardEnabled());
        $this->assertSame(['sales@company.com', 'cs@company.com'], SiteSetting::getContactForwardEmails());

        Mail::assertSent(ContactMessageForwarded::class, function (ContactMessageForwarded $mail): bool {
            return $mail->isTest
                && $mail->hasTo('sales@company.com')
                && $mail->hasTo('cs@company.com');
        });
    }

    public function test_forward_settings_requires_email_when_enabled_and_rejects_invalid_email(): void
    {
        $admin = User::factory()->create();
        $this->actingAs($admin);

        Livewire::test(ContactForwardSettings::class)
            ->fillForm([
                SiteSetting::CONTACT_FORWARD_ENABLED_KEY => true,
                SiteSetting::CONTACT_FORWARD_EMAIL_KEY => [],
            ])
            ->call('save')
            ->assertHasFormErrors([SiteSetting::CONTACT_FORWARD_EMAIL_KEY => 'required']);

        Livewire::test(ContactForwardSettings::class)
            ->fillForm([
                SiteSetting::CONTACT_FORWARD_ENABLED_KEY => true,
                SiteSetting::CONTACT_FORWARD_EMAIL_KEY => ['bukan-email'],
            ])
            ->call('save')
            ->assertHasFormErrors([SiteSetting::CONTACT_FORWARD_EMAIL_KEY . '.0']);
    }
}

