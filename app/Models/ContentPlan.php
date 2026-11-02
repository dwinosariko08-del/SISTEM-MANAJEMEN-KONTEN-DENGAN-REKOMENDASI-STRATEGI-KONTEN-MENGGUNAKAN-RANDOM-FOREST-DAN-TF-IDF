<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'posting_date',
        'status',
        'pillar',
        'topic',
        'asset_id',
        'notes_for_creator',
        'revision_notes',
        'video_revision_notes',
        'approved',
    ];

    public function editorContent()
    {
        return $this->hasOne(EditorContent::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function producedVideo()
    {
        return $this->hasOne(ProducedVideo::class);
    }

    public function analytics()
{
    return $this->hasOne(ContentAnalytics::class, 'content_plan_id');
}


}

