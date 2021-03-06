<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Migrations\Migration;

class RemoveKeywordManagePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Permission::where('name', 'keyword.manage')->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $permKeywordManage = Permission::create([
            'name'         => 'keyword.manage',
            'display_name' => '關鍵字管理權限',
            'description'  => '設定關鍵字與對應回應內容',
        ]);

        // Find Admin and give permission to him
        /* @var Role $admin */
        $admin = Role::where('name', 'Admin')->first();
        $admin->attachPermission($permKeywordManage);
    }
}
