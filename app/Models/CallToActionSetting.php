<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HandlesMediaCleanup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallToActionSetting extends Model
{
    use HandlesMediaCleanup, HasFactory;

    protected array $mediaFields = ['background_image'];

    protected $table = 'call_to_action_settings';

    protected $fillable = [
        'eyebrow',
        'title',
        'highlighted_text',
        'description',
        'background_image',
        'primary_button_text',
        'primary_button_url',
        'primary_button_new_tab',
        'secondary_button_text',
        'secondary_button_url',
        'secondary_button_new_tab',
        'is_active',
    ];

    protected $casts = [
        'primary_button_new_tab' => 'boolean',
        'secondary_button_new_tab' => 'boolean',
        'is_active' => 'boolean',
    ];
}
