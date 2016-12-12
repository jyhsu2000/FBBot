<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Migrations\Migration;

class CreateQualificationManagePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permQualificationManage = Permission::create([
            'name'         => 'qualification.manage',
            'display_name' => '抽獎資格管理權限',
            'description'  => '抽獎資格管理、進行抽獎',
        ]);

        // Find Admin and give permission to him
        /* @var Role $admin */
        $admin = Role::where('name', 'Admin')->first();
        $admin->attachPermission($permQualificationManage);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::where('name', 'qualification.manage')->delete();
    }
}
