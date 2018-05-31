<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Migrations\Migration;

class CreateFbBotManagePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permFBBotManage = Permission::create([
            'name'         => 'fb-bot.manage',
            'display_name' => '管理FB聊天機器人',
            'description'  => '進入FB聊天機器人除錯頁面',
        ]);

        /* @var Role $admin */
        $admin = Role::where('name', 'Admin')->first();
        $admin->attachPermission($permFBBotManage);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::where('name', 'fb-bot.manage')->delete();
    }
}
