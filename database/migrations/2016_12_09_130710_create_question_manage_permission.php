<?php

use App\Role;
use App\Permission;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionManagePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permQuestionManage = Permission::create([
            'name'         => 'question.manage',
            'display_name' => '問題管理權限',
            'description'  => '設定問題與答案',
        ]);

        // Find Admin and give permission to him
        /* @var Role $admin */
        $admin = Role::where('name', 'Admin')->first();
        $admin->attachPermission($permQuestionManage);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::where('name', 'question.manage')->delete();
    }
}
