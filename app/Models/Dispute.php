<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispute extends Model
{
    use HasFactory;

        protected $fillable = [
        'project_id',
        'client_id',
        'service_provider_id',
        'initial_reason',
        'status',
        'opened_at',
        'resolved_at',
        'resolved_by_user_id',
    ];

    /**
     * Get the project that owns the dispute.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the client (user) that opened the dispute.
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Get the service provider (user) related to the dispute.
     */
    public function serviceProvider()
    {
        return $this->belongsTo(User::class, 'service_provider_id');
    }

    /**
     * Get the admin (user) that resolved the dispute.
     */
    public function resolvedBy()
    {
        return $this->belongsTo(User::class, 'resolved_by_user_id');
    }

    /**
     * Get the messages for the dispute.
     */
    public function messages()
    {
        return $this->hasMany(DisputeMessage::class);
    }
}
