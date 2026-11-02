<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditorContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_plan_id',
        'post_type',
        'content_title',
        'script_brief',
        'reference',
        'caption',
        'hashtag',
        'talent',
        'editor_name',
        'preview_thumbnail',
    ];

    /**
     * RELASI KE ASSIGNMENT LEADER
     */
    public function contentPlan()
    {
        return $this->belongsTo(ContentPlan::class);
    }

     public function user()
    {
        return $this->belongsTo(User::class);
    }
}
