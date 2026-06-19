<?php

namespace Uneca\DisseminationToolkit\Tests\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Uneca\DisseminationToolkit\Enums\PermissionsEnum;
use Uneca\DisseminationToolkit\Models\Organization;
use Uneca\DisseminationToolkit\Models\User;

class TestDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Organization::firstOrCreate(
            ['id' => 1],
            [
                'name' => ['en' => 'Test Organization'],
                'website' => '#',
                'email' => 'test@example.org',
                'logo_path' => '',
                'slogan' => ['en' => 'Making data accessible.'],
                'blurb' => ['en' => 'Test blurb.'],
                'hero_image_path' => 'images/hero.svg',
                'social_media' => [
                    'twitter' => '',
                    'facebook' => '',
                    'instagram' => '',
                    'linkedin' => '',
                ],
                'address' => 'Test Address',
            ]
        );

        $permissions = collect(PermissionsEnum::cases())->map(
            fn (PermissionsEnum $permission) => Permission::firstOrCreate([
                'name' => $permission->value,
                'guard_name' => 'sanctum',
            ])
        );

        /** @var Role $superAdmin */
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'sanctum']);
        $superAdmin->syncPermissions($permissions);

        /** @var Role $manager */
        $manager = Role::firstOrCreate(['name' => 'Manager', 'guard_name' => 'sanctum']);
        $manager->syncPermissions($permissions);

        /** @var Role $contributor */
        $contributor = Role::firstOrCreate(['name' => 'Contributor', 'guard_name' => 'sanctum']);
        $contributor->syncPermissions([
            PermissionsEnum::CREATE_DATASET->value,
            PermissionsEnum::EDIT_DATASET->value,
            PermissionsEnum::CREATE_STORY->value,
            PermissionsEnum::EDIT_STORY->value,
        ]);

        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'super@example.org',
        ])->assignRole(Role::findByName('Super Admin', 'sanctum'));

        User::factory()->create([
            'name' => 'Manager',
            'email' => 'manager@example.org',
        ])->assignRole(Role::findByName('Manager', 'sanctum'));

        User::factory()->create([
            'name' => 'Contributor',
            'email' => 'contributor@example.org',
        ])->assignRole(Role::findByName('Contributor', 'sanctum'));
    }
}
