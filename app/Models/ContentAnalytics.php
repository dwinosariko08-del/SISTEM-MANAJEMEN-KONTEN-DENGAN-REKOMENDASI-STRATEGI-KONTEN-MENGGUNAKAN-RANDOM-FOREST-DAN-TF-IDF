<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentAnalytics extends Model
{
    protected $fillable = [
        'content_plan_id',
        'platform',
        'views',
        'likes',
        'comments',
        'shares',
        'posting_hour',
        'posting_day',
        'caption_length',
        'hashtag_count',
        'engagement_rate',
        'engagement_score',
    ];

    public function contentPlan()
    {
        return $this->belongsTo(ContentPlan::class);
    }
}
