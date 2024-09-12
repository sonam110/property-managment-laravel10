<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()['cache']->forget('spatie.permission.cache');

      $permissions = [
        [ 
          'name' => 'user-browse',
          'se_name' => 'user-browse',
          'group_name' => 'user',
          'guard_name' => 'web',
        ],
        [ 
          'name' => 'user-read',
          'se_name' => 'user-read',
           'group_name' => 'user',
          'guard_name' => 'web',
          
        ],
        [ 
          'name' => 'user-add',
          'se_name' => 'user-add',
           'group_name' => 'user',
          'guard_name' => 'web',
        
        ],
        [ 
          'name' => 'user-edit',
          'se_name' => 'user-edit',
           'group_name' => 'user',
          'guard_name' => 'web',
          
        ],
        [ 
          'name' => 'user-delete',
          'se_name' => 'user-delete',
           'group_name' => 'user',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'role-browse',
          'se_name' => 'role-browse',
           'group_name' => 'role',
          'guard_name' => 'web',
        
        ],
        [ 
          'name' => 'role-read',
          'se_name' => 'role-read',
           'group_name' => 'role',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'role-add',
          'se_name' => 'role-add',
           'group_name' => 'role',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'role-edit',
          'se_name' => 'role-edit',
           'group_name' => 'role',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'role-delete',
          'se_name' => 'role-delete',
           'group_name' => 'role',
          'guard_name' => 'web',
         
        ],
        [
          'name' => 'permission-browse',
          'se_name' => 'permission-browse',
           'group_name' => 'permission',
          'guard_name' => 'web',
        
        ],
        [ 
          'name' => 'permission-read',
          'se_name' => 'permission-read',
          'group_name' => 'permission',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'permission-add',
          'se_name' => 'permission-add',
          'group_name' => 'permission',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'permission-edit',
          'se_name' => 'permission-edit',
          'group_name' => 'permission',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'permission-delete',
          'se_name' => 'permission-delete',
          'group_name' => 'permission',
          'guard_name' => 'web',
         
        ],

        [ 
          'name' => 'dashboard',
          'se_name' => 'dashboard',
          'group_name' => 'dashboard',
          'guard_name' => 'web',
          
        ],
        [ 
          'name' => 'notifications-browse',
          'se_name' => 'notifications-browse',
          'group_name' => 'notifications',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'app-setting',
          'se_name' => 'app-setting',
          'group_name' => 'setting',
          'guard_name' => 'web',
         
        ],

        [
          'name' => 'tenant-browse',
          'se_name' => 'tenant-browse',
           'group_name' => 'tenant',
          'guard_name' => 'web',
        
        ],
        [ 
          'name' => 'tenant-read',
          'se_name' => 'tenant-read',
            'group_name' => 'tenant',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'tenant-add',
          'se_name' => 'tenant-add',
            'group_name' => 'tenant',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'tenant-edit',
          'se_name' => 'tenant-edit',
            'group_name' => 'tenant',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'tenant-delete',
          'se_name' => 'tenant-delete',
          'group_name' => 'tenant',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'setting-tenant',
          'se_name' => 'setting-tenant',
          'group_name' => 'setting',
          'guard_name' => 'web',
         
        ],

        [
          'name' => 'property-browse',
          'se_name' => 'property-browse',
          'group_name' => 'property',
          'guard_name' => 'web',
        
        ],
        [ 
          'name' => 'property-read',
          'se_name' => 'property-read',
           'group_name' => 'property',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'property-add',
          'se_name' => 'property-add',
           'group_name' => 'property',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'property-edit',
          'se_name' => 'property-edit',
           'group_name' => 'property',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'property-delete',
          'se_name' => 'property-delete',
           'group_name' => 'property',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'setting-property',
          'se_name' => 'setting-property',
           'group_name' => 'setting',
          'guard_name' => 'web',
         
        ],

        [
          'name' => 'lease-browse',
          'se_name' => 'lease-browse',
           'group_name' => 'lease',
          'guard_name' => 'web',
        
        ],
        [ 
          'name' => 'lease-read',
          'se_name' => 'lease-read',
          'group_name' => 'lease',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'lease-add',
          'se_name' => 'lease-add',
          'group_name' => 'lease',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'lease-edit',
          'se_name' => 'lease-edit',
          'group_name' => 'lease',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'lease-delete',
          'se_name' => 'lease-delete',
          'group_name' => 'lease',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'setting-lease',
          'se_name' => 'setting-lease',
          'group_name' => 'setting',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'invoice-browse',
          'se_name' => 'invoice-browse',
          'group_name' => 'invoice',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'invoice-rent',
          'se_name' => 'invoice-rent',
          'group_name' => 'invoice',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'invoice-cam',
          'se_name' => 'invoice-cam',
          'group_name' => 'invoice',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'invoice-utility',
          'se_name' => 'invoice-utility',
          'group_name' => 'invoice',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'lease-contract',
          'se_name' => 'lease-contract',
          'group_name' => 'setting',
          'guard_name' => 'web',
         
        ],
        [
          'name' => 'tenant-type-browse',
          'se_name' => 'tenant-type-browse',
          'group_name' => 'tenant-type',
          'guard_name' => 'web',
        
        ],
        [ 
          'name' => 'tenant-type-read',
          'se_name' => 'tenant-type-read',
           'group_name' => 'tenant-type',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'tenant-type-add',
          'se_name' => 'tenant-type-add',
          'group_name' => 'tenant-type',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'tenant-type-edit',
          'se_name' => 'tenant-type-edit',
          'group_name' => 'tenant-type',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'tenant-type-delete',
          'se_name' => 'tenant-type-delete',
          'group_name' => 'tenant-type',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'report-browse',
          'se_name' => 'report-browse',
          'group_name' => 'report',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'report-download',
          'se_name' => 'report-download',
           'group_name' => 'report',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'property-type-add',
          'se_name' => 'property-type-add',
          'group_name' => 'property-type',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'property-type-edit',
          'se_name' => 'property-type-edit',
          'group_name' => 'property-type',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'property-type-delete',
          'se_name' => 'property-type-delete',
          'group_name' => 'property-type',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'unit-type-add',
          'se_name' => 'unit-type-add',
          'group_name' => 'unit-type',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'unit-type-edit',
          'se_name' => 'unit-type-edit',
          'group_name' => 'unit-type',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'unit-type-delete',
          'se_name' => 'unit-type-delete',
          'group_name' => 'unit-type',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'utility-type-add',
          'se_name' => 'utility-type-add',
          'group_name' => 'utility-type',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'utility-type-edit',
          'se_name' => 'utility-type-edit',
          'group_name' => 'utility-type',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'utility-type-delete',
          'se_name' => 'utility-type-delete',
          'group_name' => 'utility-type',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'lease-type-add',
          'se_name' => 'lease-type-add',
          'group_name' => 'lease-type',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'lease-type-edit',
          'se_name' => 'lease-type-edit',
          'group_name' => 'lease-type',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'lease-type-delete',
          'se_name' => 'lease-type-delete',
          'group_name' => 'lease-type',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'extra-charge-add',
          'se_name' => 'extra-charge-add',
          'group_name' => 'extra-charge',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'extra-charge-edit',
          'se_name' => 'extra-charge-edit',
          'group_name' => 'extra-charge',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'extra-charge-delete',
          'se_name' => 'extra-charge-delete',
          'group_name' => 'extra-charge',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'payment-add',
          'se_name' => 'payment-add',
          'group_name' => 'payment',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'payment-edit',
          'se_name' => 'payment-edit',
          'group_name' => 'payment',
          'guard_name' => 'web',
         
        ],
        [ 
          'name' => 'payment-delete',
          'se_name' => 'payment-delete',
          'group_name' => 'payment',
          'guard_name' => 'web',
         
        ],

       

        ];

       foreach ($permissions as $key => $permission) {
        Permission::create($permission);
      }
      
    }
}
