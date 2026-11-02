<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProducedVideo extends Model
{
    protected $fillable = [
        'content_plan_id',
        'video_path',
        'notes',
        'uploaded_at',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
    ];

    public function contentPlan()
    {
        return $this->belongsTo(ContentPlan::class);
    }
}
