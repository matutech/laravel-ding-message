<?php


namespace Matu\Ding\Commands;


use Illuminate\Console\Command;
use Matu\Ding\Models\DingDepartment;
use Matu\Ding\Models\DingDepartmentUser;
use Matu\Ding\Service\DingDepartmentService;

class UserCommand extends Command
{
    protected $name = 'ding:user';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '钉钉用户管理';

    public function handle(DingDepartmentService $departmentService)
    {
        $name = $this->choice('您希望：list 获取已存在的用户；reset 从钉钉获取并更新用户', ['list', 'reset'], false);

        if ($name == 'reset') {
            // 获取全部部门供选择
            $departmentArr  = DingDepartment::all()->pluck('department_name')->toArray();
            $departmentName = $this->choice('请选择部门:', $departmentArr);
            // 查找部门
            $department = DingDepartment::where('department_name', $departmentName)->first();

            $departmentService->getDepartmentUser($department->department_id);
        }


        $header = ['部门 id', '部门名称', '用户 id', '用户名称'];

        $lists = DingDepartmentUser::with('department')->get();

        $data = [];
        foreach ($lists as $key => $value) {
            $data[$key]['department_id']   = $value->department->department_id;
            $data[$key]['department_name'] = $value->department->department_name;
            $data[$key]['userid']          = $value->userid;
            $data[$key]['name']            = $value->name;
        }

        $this->table($header, $data);
    }
}
