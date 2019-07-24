<?php

namespace Matu\Ding\Models;

use Illuminate\Database\Eloquent\Model;

class DingDepartment extends Model
{
    protected $fillable = [
        'department_id',
        'department_pid',
        'department_name',
        'auto_add_user',
        'create_dept_group',
    ];

}
