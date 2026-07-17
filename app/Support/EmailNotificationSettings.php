<?php

namespace App\Support;

use App\Models\GlobalSetting;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailNotificationSettings
{
    /**
     * Read a checkbox toggle stored as '1'/'0' in global_settings. Falls back to
     * $default when the admin has never saved this key yet.
     */
    public static function enabled(string $key, bool $default): bool
    {
        $value = GlobalSetting::get($key);

        return $value === null ? $default : $value === '1';
    }

    /**
     * Admin recipient list, sourced from the existing Mail Settings "Admin Receiver
     * Emails" field so it isn't duplicated on the notifications page. Falls back to
     * ADMIN_EMAIL / mail.from.address if the admin never configured that field.
     */
    public static function adminRecipients(): array
    {
        $raw    = GlobalSetting::get('mail_admin_emails');
        $emails = $raw ? (json_decode($raw, true) ?: []) : [];
        $emails = array_values(array_filter($emails));

        return $emails ?: array_filter([env('ADMIN_EMAIL', config('mail.from.address'))]);
    }

    /**
     * Sends a fresh mailable (built per-recipient by $factory) to each admin recipient
     * as its own separate message, rather than one email with every admin listed in the
     * To: header. This keeps admin addresses private from each other and stops one
     * recipient's delivery problem (bounce, spam filter, etc.) from being silently
     * bundled with the rest — each attempt is logged independently.
     *
     * A factory (not a shared Mailable instance) is required because Mailable::to()
     * appends to its internal recipient list rather than replacing it — reusing one
     * instance across a loop of Mail::to($email)->send($mailable) calls would leave
     * every message addressed to all recipients, not just the current one.
     *
     * @param \Closure(): Mailable $factory
     */
    public static function sendToAdmins(\Closure $factory, string $logContext = 'Admin'): void
    {
        foreach (self::adminRecipients() as $email) {
            try {
                Mail::to($email)->send($factory());
            } catch (\Throwable $e) {
                Log::error("{$logContext} email failed for {$email}: " . $e->getMessage());
            }
        }
    }

    /**
     * Admin-editable static template string, falling back to the given default
     * (the copy that shipped in the blade view) when never customized.
     */
    public static function template(string $key, string $default): string
    {
        $value = GlobalSetting::get($key);

        return $value !== null && $value !== '' ? $value : $default;
    }
}
