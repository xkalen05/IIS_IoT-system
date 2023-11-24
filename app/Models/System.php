<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'system_admin_id',
        'kpis'
    ];

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'system_users', 'system_id', 'user_id');
    }

    public function devices(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(Device::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'system_admin_id');
    }

    /**
     * Send a sharing request for the system.
     *
     * @param int $requestUserId
     * @return void
     */
    public function sendSharingRequest(int $requestUserId): void
    {
        SystemSharingRequest::create([
            'system_id' => $this->id,
            'user_id' => auth()->id(),
            'request_user_id' => $requestUserId,
        ]);
    }

    /**
     * Get the sharing requests for the system.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sharingRequests()
    {
        return $this->hasMany(SystemSharingRequest::class);
    }

}
