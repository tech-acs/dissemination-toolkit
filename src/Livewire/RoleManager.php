<?php

namespace Uneca\DisseminationToolkit\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Uneca\DisseminationToolkit\Enums\PermissionsEnum;

class RoleManager extends Component
{
    public $permissionGroups;
    public $role;
    public array $permissions = [];

    public function mount()
    {
        $this->permissionGroups = PermissionsEnum::grouped();
        foreach (($this->permissionGroups ?? []) as $permissionGroup) {
            foreach ($permissionGroup as $permissionName => $permissionLabel) {
                $this->permissions[$permissionName] = $this->role->hasPermissionTo($permissionName);
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
