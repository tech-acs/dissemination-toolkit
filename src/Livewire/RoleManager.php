<?php

namespace Uneca\DisseminationToolkit\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;

class RoleManager extends Component
{
    public $permissionGroups;
    public $role;
    public array $permissions = [];

    public function mount()
    {
        $this->permissionGroups = collect(config('app-permissions.groups'));
        foreach (($this->permissionGroups ?? []) as $permissionGroup) {
            foreach ($permissionGroup['permissions'] as $permission) {
                //Permission::firstOrCreate(['guard_name' => 'web', 'name' => $permission['permission_name']]);
                $this->permissions[$permission['permission_name']] = $this->role->hasPermissionTo($permission['permission_name']);
            }
        }
    }

    public function save()
    {
        $filtered = collect($this->permissions)->filter(function ($value, $key) {
            return $value;
        })->keys();
        $this->role->syncPermissions($filtered);
        $this->dispatch('roleUpdated');
    }

    public function render()
    {
        return view('dissemination::livewire.role-manager');
    }
}
