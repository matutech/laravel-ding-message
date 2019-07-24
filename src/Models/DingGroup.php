<?php

namespace Matu\Ding\Models;

use Illuminate\Database\Eloquent\Model;

class DingGroup extends Model
{
    protected $fillable = [
        'chatid',
        'name',
        'open_conversation_id',
        'conversation_tag',
        'is_send'
    ];
}
