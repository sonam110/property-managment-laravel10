<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Module;
use App\Models\AppSetting;
use DB;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('roles')->delete();
        Role::create([
            'id' => '1',
            'name' => 'Admin',
            'se_name' => 'Admin',
            'guard_name' => 'web',
        ]);
        
        Role::create([
            'id' => '2',
            'name' => 'Partner',
            'se_name' => 'Partner',
            'guard_name' => 'web',
        ]);
        Role::create([
            'id' => '3',
            'name' => 'Tenant',
            'se_name' => 'Tenant',
            'guard_name' => 'web',
        ]);

        $adminUser = new User();
        $adminUser->role_id                 = '1';
        $adminUser->first_name                    = 'admin';
        $adminUser->email                   = 'admin@gmail.com';
        $adminUser->password                = \Hash::make('123456');
        $adminUser->created_by                = '1';
        $adminUser->save();
        $admin = $adminUser;

        $appSetting = new AppSetting();
        $appSetting->id                      = '1';
        $appSetting->app_name                = 'Property Management';
        $appSetting->description             = 'Property Management';
        $appSetting->email                   = 'sonam.patel@nrt.co.in';
        $appSetting->mobile_no               = '8103099592';
        $appSetting->save();

        $adminRole = Role::where('id','1')->first();
       
        
        $adminUser->assignRole($adminRole);
            

        $adminPermissions = Permission::select('id','name')->get();
        foreach ($adminPermissions as $key => $permission) {
            $addedPermission = $permission->name;
            $adminRole->givePermissionTo($addedPermission);
        }

        
    }
}
