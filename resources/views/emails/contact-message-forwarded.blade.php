<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Kontak Baru</title>
</head>
<body style="margin:0;padding:0;background-color:#f3f4f6;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;color:#1f2937;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#f3f4f6;padding:24px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" style="max-width:600px;width:100%;background-color:#ffffff;border-radius:12px;overflow:hidden;border:1px solid #e5e7eb;">
                    <tr>
                        <td style="background-color:#15803d;padding:24px 28px;color:#ffffff;">
                            <p style="margin:0 0 6px 0;font-size:12px;letter-spacing:0.06em;text-transform:uppercase;opacity:0.9;">
                                {{ $companyName }}
                            </p>
                            <h1 style="margin:0;font-size:20px;line-height:1.3;font-weight:700;">
                                {{ !empty($isTest) ? 'Uji Coba Forward Email Pesan Kontak' : 'Pesan Kontak Baru dari Website' }}
                            </h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:28px;">
                            <p style="margin:0 0 18px 0;font-size:14px;line-height:1.6;color:#4b5563;">
                                @if(!empty($isTest))
                                    Ini adalah email uji coba dari pengaturan panel admin untuk memastikan konfigurasi forward email berjalan dengan baik.
                                @else
                                    Ada pesan baru yang dikirim melalui formulir kontak website dan telah tersimpan di panel admin.
                                @endif
                            </p>

                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#f9fafb;border:1px solid #e5e7eb;border-radius:8px;margin-bottom:20px;">
                                <tr>
                                    <td style="padding:14px 18px;border-bottom:1px solid #e5e7eb;font-size:13px;">
                                        <strong style="color:#374151;display:inline-block;width:110px;">Nama</strong>
                                        <span style="color:#111827;">{{ $contactMessage->name }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:14px 18px;border-bottom:1px solid #e5e7eb;font-size:13px;">
                                        <strong style="color:#374151;display:inline-block;width:110px;">Email</strong>
                                        <a href="mailto:{{ $contactMessage->email }}" style="color:#15803d;text-decoration:none;">
                                            {{ $contactMessage->email }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:14px 18px;font-size:13px;">
                                        <strong style="color:#374151;display:inline-block;width:110px;">Waktu Kirim</strong>
                                        <span style="color:#111827;">
                                            {{ optional($contactMessage->created_at)->format('d M Y, H:i') ?? now()->format('d M Y, H:i') }}
                                        </span>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:0 0 8px 0;font-size:13px;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:0.04em;">
                                Isi Pesan
                            </p>
                            <div style="background-color:#ffffff;border:1px solid #e5e7eb;border-left:4px solid #16a34a;border-radius:6px;padding:16px 18px;font-size:14px;line-height:1.7;color:#111827;margin-bottom:24px;">
                                {!! nl2br(e($contactMessage->message)) !!}
                            </div>

                            <table role="presentation" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="border-radius:8px;background-color:#16a34a;">
                                        <a href="{{ $adminUrl }}" target="_blank" rel="noopener noreferrer" style="display:inline-block;padding:12px 20px;font-size:14px;font-weight:600;color:#ffffff;text-decoration:none;">
                                            Buka Pesan di Panel Admin
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:20px 0 0 0;font-size:12px;line-height:1.6;color:#6b7280;">
                                Tip: Anda dapat langsung membalas email ini (Reply) untuk menghubungi {{ $contactMessage->name }}.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
