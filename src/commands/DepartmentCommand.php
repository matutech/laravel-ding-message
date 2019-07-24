<?php

namespace Matu\Ding\Commands;

use Illuminate\Console\Command;
use Matu\Ding\Models\DingDepartment;
use Matu\Ding\Service\DingDepartmentService;

class DepartmentCommand extends Command
{

    protected $name = 'ding:department';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '钉钉部门管理';


    public function handle(DingDepartmentService $departmentService)
    {
        $name = $this->choice('您希望：list 获取已存在的部门；reset 从钉钉获取并更新部门', ['list', 'reset'], false);

        if ($name == 'reset') {
            $departmentService->getDepartment();
        }

        $header = ['部门 id', '部门名称'];

        $lists = DingDepartment::all(['department_id', 'department_name'])->toArray();
        $this->table($header, $lists);
    }
}
