<?php


namespace Matu\Ding\commands;


use Illuminate\Console\Command;
use Matu\Ding\Models\DingDepartmentUser;
use Matu\Ding\Models\DingGroup;
use Matu\Ding\Service\DingGroupService;

class GroupCommand extends Command
{
    protected $name = 'ding:group';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '钉钉群管理';

    public function handle(DingGroupService $dingGroupService)
    {

        $name = $this->choice('请选择您的群操作, list 查看群列表; create 创建一个群', ['list', 'create']);

        if ($name == 'create') {

            $count = DingGroup::query()->count();
            if ($this->confirm("当前已有{$count}个群，你是否还需要创建?")) {
                //输入群名
                $groupName = $this->ask('请输入群名,不超过 15 个字');

                // 查找群名是否存在
                $dingGroup = DingGroup::where('name', $groupName)->first();
                if ($dingGroup) {
                    $this->error('该群名称已存在，请勿重复创建');
                    die;
                }
                // 组合用户名称
                $userLists = DingDepartmentUser::all()->groupBy('name')->toArray();
                $userLists = array_keys($userLists);
                if (count($userLists)<=0){
                    $this->error('当前没有可选择用户，请先获取用户');
                    die;
                }
                // 选择用户
                $userName = $this->choice('请选择一个人作为群主', $userLists);

                // 查找用户
                $user = DingDepartmentUser::where('name', $userName)->first();
                if ($user) {
                    $dingGroupService->createChat($groupName, $user->userid);
                }
            }


        }
        $header = ['钉钉群聊 id', '群名称','是否发送消息群 1是 0 不是'];

        $lists = DingGroup::all(['chatid', 'name','is_send'])->toArray();

        $this->table($header, $lists);
    }
}
