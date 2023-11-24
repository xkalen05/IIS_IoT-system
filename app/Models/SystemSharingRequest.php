<?php

namespace App\Models;

// app/Models/SystemSharingRequest.php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SystemSharingRequest extends Model
{
    protected $fillable = [
        'system_id',
        'request_user_id',
        'system_owner_id'
    ];

    /**
     * Relationship with the system.
     *
     * @return BelongsTo
     */
    public function system(): BelongsTo
    {
        return $this->belongsTo(System::class, 'system_id');
    }

    /**
     * Relationship with the user who sent the request.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Assuming you have a 'requestUser' relationship defined
    public function requestUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'request_user_id');
    }

    /**
     * Relationship with the user to whom the request is sent.
     *
     * @return BelongsTo
     */
    public function systemOwner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'system_owner_id');
    }

    public static function hasPendingRequest($systemId, $userId)
    {
        return self::where('system_id', $systemId)
            ->where('request_user_id', $userId)
            ->exists();
    }
}

