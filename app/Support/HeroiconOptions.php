<?php

declare(strict_types=1);

namespace App\Support;

class HeroiconOptions
{
    /**
     * Canonical list of all available Heroicons for CMS selection.
     * Values are the blade-icons component name (heroicon-o-*).
     * Keys are the stored database value.
     */
    public static function all(): array
    {
        return [
            // ── General ──────────────────────────────────────────────────────
            'heroicon-o-home' => 'Home',
            'heroicon-o-star' => 'Star',
            'heroicon-o-sparkles' => 'Sparkles',
            'heroicon-o-bolt' => 'Bolt',
            'heroicon-o-fire' => 'Fire',
            'heroicon-o-heart' => 'Heart',
            'heroicon-o-check-circle' => 'Check Circle',
            'heroicon-o-check-badge' => 'Check Badge',
            'heroicon-o-light-bulb' => 'Light Bulb',
            'heroicon-o-cursor-arrow-rays' => 'Cursor / Click',

            // ── Business / Corporate ─────────────────────────────────────────
            'heroicon-o-building-office' => 'Building Office',
            'heroicon-o-building-office-2' => 'Building Office 2',
            'heroicon-o-briefcase' => 'Briefcase',
            'heroicon-o-users' => 'Users',
            'heroicon-o-user-group' => 'User Group',
            'heroicon-o-user' => 'User',
            'heroicon-o-chart-bar' => 'Chart Bar',
            'heroicon-o-presentation-chart-line' => 'Presentation Chart',
            'heroicon-o-trophy' => 'Trophy',
            'heroicon-o-banknotes' => 'Banknotes',
            'heroicon-o-currency-dollar' => 'Currency Dollar',
            'heroicon-o-clipboard-document-check' => 'Clipboard Check',
            'heroicon-o-document-text' => 'Document Text',

            // ── Technology / Development ─────────────────────────────────────
            'heroicon-o-code-bracket' => 'Code Bracket',
            'heroicon-o-code-bracket-square' => 'Code Bracket Square',
            'heroicon-o-command-line' => 'Command Line',
            'heroicon-o-cpu-chip' => 'CPU Chip',
            'heroicon-o-server-stack' => 'Server Stack',
            'heroicon-o-server' => 'Server',
            'heroicon-o-cloud' => 'Cloud',
            'heroicon-o-cloud-arrow-up' => 'Cloud Upload',
            'heroicon-o-globe-alt' => 'Globe',
            'heroicon-o-link' => 'Link',
            'heroicon-o-window' => 'Window',
            'heroicon-o-device-phone-mobile' => 'Mobile App',
            'heroicon-o-device-tablet' => 'Tablet',
            'heroicon-o-computer-desktop' => 'Desktop',
            'heroicon-o-circle-stack' => 'Database',
            'heroicon-o-wifi' => 'Network / WiFi',
            'heroicon-o-signal' => 'Signal',

            // ── Design / Creative ────────────────────────────────────────────
            'heroicon-o-paint-brush' => 'Paint Brush',
            'heroicon-o-swatch' => 'Swatch / Brand Color',
            'heroicon-o-photo' => 'Photo',
            'heroicon-o-camera' => 'Camera',
            'heroicon-o-video-camera' => 'Video Camera',
            'heroicon-o-film' => 'Film',
            'heroicon-o-musical-note' => 'Musical Note',
            'heroicon-o-eye' => 'Eye / Visual',
            'heroicon-o-cube-transparent' => 'Cube Transparent / 3D',
            'heroicon-o-squares-2x2' => 'Grid / Layout',
            'heroicon-o-rectangle-stack' => 'Rectangle Stack',
            'heroicon-o-adjustments-horizontal' => 'Adjustments',

            // ── Marketing / Growth ───────────────────────────────────────────
            'heroicon-o-megaphone' => 'Megaphone',
            'heroicon-o-rocket-launch' => 'Rocket Launch',
            'heroicon-o-arrow-trending-up' => 'Trending Up',
            'heroicon-o-chart-pie' => 'Chart Pie',
            'heroicon-o-magnifying-glass' => 'Search / SEO',
            'heroicon-o-envelope' => 'Email',
            'heroicon-o-envelope-open' => 'Email Open',
            'heroicon-o-chat-bubble-left-right' => 'Chat / Communication',
            'heroicon-o-chat-bubble-left' => 'Chat Bubble',
            'heroicon-o-speaker-wave' => 'Speaker / Audio',

            // ── Security / Access ────────────────────────────────────────────
            'heroicon-o-shield-check' => 'Shield Check',
            'heroicon-o-shield-exclamation' => 'Shield Warning',
            'heroicon-o-lock-closed' => 'Lock Closed',
            'heroicon-o-lock-open' => 'Lock Open',
            'heroicon-o-key' => 'Key',
            'heroicon-o-finger-print' => 'Fingerprint',

            // ── Location / Contact ───────────────────────────────────────────
            'heroicon-o-map-pin' => 'Map Pin / Location',
            'heroicon-o-map' => 'Map',
            'heroicon-o-phone' => 'Phone',
            'heroicon-o-phone-arrow-up-right' => 'Phone Call',

            // ── Navigation / UI ──────────────────────────────────────────────
            'heroicon-o-bars-3' => 'Menu / Bars',
            'heroicon-o-arrow-right' => 'Arrow Right',
            'heroicon-o-arrow-left' => 'Arrow Left',
            'heroicon-o-arrow-up-right' => 'Arrow Up Right',
            'heroicon-o-chevron-right' => 'Chevron Right',
            'heroicon-o-plus-circle' => 'Plus Circle',
            'heroicon-o-information-circle' => 'Info',
            'heroicon-o-question-mark-circle' => 'Question Mark',
            'heroicon-o-exclamation-circle' => 'Exclamation',
            'heroicon-o-cog-6-tooth' => 'Settings',
            'heroicon-o-wrench-screwdriver' => 'Wrench / Tools',
        ];
    }

    /**
     * Subset for service icons — returns from all() for consistency.
     */
    public static function services(): array
    {
        return array_intersect_key(self::all(), array_flip([
            'heroicon-o-code-bracket',
            'heroicon-o-code-bracket-square',
            'heroicon-o-command-line',
            'heroicon-o-paint-brush',
            'heroicon-o-photo',
            'heroicon-o-camera',
            'heroicon-o-video-camera',
            'heroicon-o-film',
            'heroicon-o-megaphone',
            'heroicon-o-rocket-launch',
            'heroicon-o-globe-alt',
            'heroicon-o-device-phone-mobile',
            'heroicon-o-computer-desktop',
            'heroicon-o-cpu-chip',
            'heroicon-o-server-stack',
            'heroicon-o-cloud',
            'heroicon-o-swatch',
            'heroicon-o-cube-transparent',
            'heroicon-o-chart-bar',
            'heroicon-o-magnifying-glass',
            'heroicon-o-shield-check',
            'heroicon-o-bolt',
            'heroicon-o-sparkles',
            'heroicon-o-briefcase',
            'heroicon-o-building-office',
            'heroicon-o-wrench-screwdriver',
            'heroicon-o-adjustments-horizontal',
        ]));
    }
}
