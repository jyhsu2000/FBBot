<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Migrations\Migration;

class CreateAutoReplyManagePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permKeywordManage = Permission::create([
            'name'         => 'autoReply.manage',
            'display_name' => '自動回覆管理權限',
            'description'  => '設定關鍵字與對應回應內容',
        ]);

        // Find Admin and give permission to him
        /* @var Role $admin */
        $admin = Role::where('name', 'Admin')->first();
        $admin->attachPermission($permKeywordManage);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::where('name', 'autoReply.manage')->delete();
    }
}
