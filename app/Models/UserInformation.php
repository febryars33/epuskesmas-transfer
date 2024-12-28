<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserInformation extends Model
{
    /**
     * Get the user that owns the UserInformation
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
