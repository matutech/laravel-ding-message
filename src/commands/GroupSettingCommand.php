<?php


namespace Matu\Ding\commands;


use Illuminate\Console\Command;
use Matu\Ding\Models\DingGroup;

class GroupSettingCommand extends Command
{
    protected $name = 'ding:setting';

    protected $description = '钉钉消息发送群设置';

    public function handle()
    {
        // 查找所有群

        $group = DingGroup::pluck('name')->toArray();

        $groupName = $this->choice('请选择您要发送消息的群', $group);

        // 根据群名查找群，
        DingGroup::query()->update(['is_send' => 0]);
        DingGroup::query()->where('name', $groupName)->update(['is_send' => 1]);
    }

}
