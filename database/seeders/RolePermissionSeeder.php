<?php

namespace Database\Seeders;

use DevPM\Application\User\Persistence\Model\User;
use DevPM\Domain\Enums\GuardEnum;
use DevPM\Domain\Enums\RoleEnum;
use DevPM\Infrastructure\Constants\Permission\PermissionConstant;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = PermissionConstant::PERMISSIONS_ARRAY;

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'api']);
        }

        $admin = Role::firstOrCreate(['name' => RoleEnum::ADMIN->value, 'guard_name' => 'api']);
        $staff = Role::firstOrCreate(['name' => RoleEnum::STAFF->value, 'guard_name' => 'api']);

        $admin->givePermissionTo(Permission::all());

        $staff->givePermissionTo([
            PermissionConstant::PERMISSIONS_VIEW[PermissionConstant::COMPANIES_ENTITY],
            PermissionConstant::PERMISSIONS_VIEW[PermissionConstant::PROJECTS_ENTITY]
        ]);

        $user = User::first();

        if ($user) {
            $user->assignRole(RoleEnum::ADMIN->value);
        }
    }
}
