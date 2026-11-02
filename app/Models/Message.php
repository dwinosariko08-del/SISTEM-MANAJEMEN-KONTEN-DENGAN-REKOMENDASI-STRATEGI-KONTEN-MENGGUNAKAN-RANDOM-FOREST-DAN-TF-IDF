<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'message',
        'file',
        'is_read'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'sender_id');
    }

    public function conversation()
{
    return $this->belongsTo(Conversation::class);
}
}