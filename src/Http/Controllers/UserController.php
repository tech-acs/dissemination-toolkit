<?php

namespace Uneca\DisseminationToolkit\Http\Controllers;

use App\Http\Controllers\Controller;
use Uneca\DisseminationToolkit\Models\Invitation;
use Uneca\DisseminationToolkit\Models\User;
use Uneca\DisseminationToolkit\Services\SmartTableColumn;
use Uneca\DisseminationToolkit\Services\SmartTableData;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return (new SmartTableData(User::with('roles'), $request))
            ->columns([
                SmartTableColumn::make('name')
                    ->sortable()
                    ->setBladeTemplate('<div class="flex items-center">
                                                        <div class="flex-shrink-0 h-8 w-8">
                                                            <img class="h-8 w-8 rounded-full object-cover" src="{{ $row->profile_photo_url }}" alt="{{ $row->name }}" />
                                                        </div>
                                                        <div class="ml-2 font-medium text-gray-900">
                                                            {{ $row->name }}
                                                        </div>
                                                    </div>'),
                SmartTableColumn::make('email')
                    ->sortable(),
                SmartTableColumn::make('created_at')
                    ->setLabel('Created')
                    ->sortable()
                    ->setBladeTemplate('{{ $row->created_at->locale(app()->getLocale())->isoFormat("ll") }}'),
                SmartTableColumn::make('role')
                    ->setBladeTemplate('<div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-gray-600">{{ $row->roles->pluck("name")->join(", ") }}</div>'),
            ])
            ->searchable(['name', 'email'])
            ->sortBy('name')
            ->view('dissemination::manage.user.index', ['users_count' => User::count(), 'invitations_count' => Invitation::count()]);
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('dissemination::manage.user.manage', compact('user', 'roles'));
    }

    public function update(User $user, Request $request)
    {
        $user->syncRoles([$request->get('role')]);
        return redirect()->route('manage.user.index');
    }

    public function destroy(User $user)
    {
        $user->deleteProfilePhoto();
        $user->usageStats()->delete();
        $user->delete();
        return redirect()->route('manage.user.index');
    }
}
