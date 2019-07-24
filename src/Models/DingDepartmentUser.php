<?php

namespace Matu\Ding\Models;

use Illuminate\Database\Eloquent\Model;

class DingDepartmentUser extends Model
{
    protected $fillable = [
        'department_id',
        'userid',
        'name'
    ];

    public function department()
    {
        return $this->belongsTo(DingDepartment::class, 'department_id', 'department_id');
    }
}
