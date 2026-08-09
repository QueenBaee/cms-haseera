<?php

namespace App\Support;

class AdminGoogleAllowlist
{
    public static function contains(?string $email): bool
    {
        $normalizedEmail = self::normalize($email);

        if ($normalizedEmail === null) {
            return false;
        }

        return in_array($normalizedEmail, self::emails(), true);
    }

    public static function normalize(?string $email): ?string
    {
        $normalizedEmail = mb_strtolower(trim((string) $email));

        return $normalizedEmail === '' ? null : $normalizedEmail;
    }

    /**
     * @return list<string>
     */
    private static function emails(): array
    {
        return array_values(array_unique(array_filter(array_map(
            self::normalize(...),
            explode(',', (string) config('haseera.admin_google_emails', '')),
        ))));
    }
}
