<?php

namespace Database\Seeders;

use App\Models\rolesModel;
use App\Models\UserModel as User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\userRoleModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\permissionModel;
use App\Models\role_permissionModel;
use App\Models\routePermissionModel;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'username' => 'uchihanemo',
            'password' => 'uchihanemo',
        ]);
        user::factory()->create([
            'username'=> 'ono',
            'password'=> 'onoonoono',
        ]);
        PermissionModel::factory()->create([
            'permissions_name' => 'thêm quyền hạn',
            'type' => 'permission',
            'user_creately' => 'uchihanemo',
        ]);
        
        permissionModel::factory()->create([
            'permissions_name' => 'sửa quyền hạn',
            'type' => 'permission',
            'user_creately' => 'uchihanemo',
        ]);

        permissionModel::factory()->create([
            'permissions_name' => 'xoá quyền hạn',
            'type' => 'permission',
            'user_creately' => 'uchihanemo',
        ]);

        permissionModel::factory()->create([
            'permissions_name' => 'danh sách quyền hạn',
            'type' => 'permission',
            'user_creately' => 'uchihanemo',
        ]);

        permissionModel::factory()->create([
            'permissions_name' => 'cấp quyền người dùng',
            'type' => 'userrole',
            'user_creately' => 'uchihanemo',
        ]);

        permissionModel::factory()->create([
            'permissions_name' => 'sửa quyền người dùng',
            'type' => 'userrole',
            'user_creately' => 'uchihanemo',
        ]);

        permissionModel::factory()->create([
            'permissions_name' => 'xoá quyền người dùng',
            'type' => 'userrole',
            'user_creately' => 'uchihanemo',
        ]);

        permissionModel::factory()->create([
            'permissions_name' => 'danh sách quyền người dùng',
            'type' => 'userrole',
            'user_creately' => 'uchihanemo',
        ]);



        routePermissionModel::factory()->create([
            'id' => 1,
            'permissions_name' => 'thêm quyền hạn',
            'route_name' => 'permission.create',
            
        ]);

        routePermissionModel::factory()->create([
            'id' => 2,
            'permissions_name' => 'sửa quyền hạn',
            'route_name' => 'permission.edit',
           
        ]);

        routePermissionModel::factory()->create([
            'id' => 3,
            'permissions_name' => 'xoá quyền hạn',
            'route_name' => 'permission.delete',
            
        ]);

        routePermissionModel::factory()->create([
            'id' => 4,
            'permissions_name' => 'danh sách quyền hạn',
            'route_name' => 'permission.list',
            
        ]);

        routePermissionModel::factory()->create([
            'id' => 5,
            'permissions_name' => 'cấp quyền người dùng',
            'route_name' => 'userrole.create',
            
        ]);

        routePermissionModel::factory()->create([
            'id' => 6,
            'permissions_name' => 'sửa quyền người dùng',
            'route_name' => 'userrole.edit',
            
        ]);

        routePermissionModel::factory()->create([
            'id' => 7,
            'permissions_name' => 'xoá quyền người dùng',
            'route_name' => 'userrole.delete',
            
        ]);

        routePermissionModel::factory()->create([
            'id' => 8,
            'permissions_name' => 'danh sách quyền người dùng',
            'route_name' => 'userrole.list',
            
        ]);

        rolesModel::factory()->create([
            'role_name' => 'Quản trị viên',
            'assigned_at' => now(),
        ]);

        role_permissionModel::factory()->create([
            'id' => 1,
            'permission_name' => 'thêm quyền hạn',
            'role_name' => 'Quản trị viên',
            'assigned_at' => now(),
        ]);
        role_permissionModel::factory()->create([
            'id' => 2,
            'permission_name' => 'sửa quyền hạn',
            'role_name' => 'Quản trị viên',
            'assigned_at' => now(),
        ]);
        role_permissionModel::factory()->create([
            'id' => 3,
            'permission_name' => 'xoá quyền hạn',
            'role_name' => 'Quản trị viên',
            'assigned_at' => now(),
        ]);

         role_permissionModel::factory()->create([
            'id' => 4,
            'permission_name' => 'danh sách quyền hạn',
            'role_name' => 'Quản trị viên',
            'assigned_at' => now(),
        ]);

         role_permissionModel::factory()->create([
            'id' => 5,
            'permission_name' => 'cấp quyền người dùng',
            'role_name' => 'Quản trị viên',
            'assigned_at' => now(),
        ]);

         role_permissionModel::factory()->create([
            'id' => 6,
            'permission_name' => 'sửa quyền người dùng',
            'role_name' => 'Quản trị viên',
            'assigned_at' => now(),
        ]);

         role_permissionModel::factory()->create([
            'id' => 7,
            'permission_name' => 'xoá quyền người dùng',
            'role_name' => 'Quản trị viên',
            'assigned_at' => now(),
        ]);
        role_permissionModel::factory()->create([
            'id' => 8,
            'permission_name' => 'danh sách quyền người dùng',
            'role_name' => 'Quản trị viên',
            'assigned_at' => now(),
        ]);
        role_permissionModel::factory()->create([
            'id' => 9,
            'permission_name' => 'tạo người dùng',
            'role_name' => 'Quản trị viên',
            'assigned_at' => now(),
        ]);
        role_permissionModel::factory()->create([
            'id'=> 10,
            'permission_name' => 'tạo phần cứng',
            'role_name' => 'Quản trị viên',
            'assigned_at' => now(),
        ]);
        role_permissionModel::factory()->create([
            'id'=> 11,
            'permission_name' => 'tạo phần mềm',
            'role_name' => 'Quản trị viên',
            'assigned_at' => now(),
        ]);

        userRoleModel::factory()->create([
            'username' => 'uchihanemo',
            'role_name' => 'Quản trị viên',
            'assigned_at' => now(),
        ]);

    }
}
