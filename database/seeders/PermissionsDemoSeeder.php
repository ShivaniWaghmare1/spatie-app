<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'delete-product']);
        Permission::create(['name' => 'update-product']);
        Permission::create(['name' => 'store-product']);

        // create roles and assign existing permissions
        $DEO = Role::create(['name' => 'Data Entry Operator']);
        $DEO->givePermissionTo('update-product');
        $DEO->givePermissionTo('delete-product');

        $CCTC = Role::create(['name' => 'Callcenter Telecaller']);
        $CCTC->givePermissionTo('update-product');

        $ADM = Role::create(['name' => 'Admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $user = \App\Models\User::factory()->create([
            'name' => 'User3',
            'mobile' => 1234567891,
        ]);
        $user->assignRole($DEO);

        $user = \App\Models\User::factory()->create([
            'name' => 'User2',
            'mobile' => 1234567891,
        ]);
        $user->assignRole($CCTC);

        $user = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'mobile' => 1234567890,
        ]);
        $user->assignRole($ADM);
    }
}
