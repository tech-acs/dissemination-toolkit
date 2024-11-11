<?php

namespace Uneca\DisseminationToolkit\Http\Controllers;

use App\Http\Controllers\Controller;
use Uneca\DisseminationToolkit\Models\User;

class UserSuspensionController extends Controller
{
    public function __invoke(User $user)
    {
        if ($user->is_suspended) {
            $user->update(['is_suspended' => false]);
            return redirect()->route('manage.user.index')
                ->withMessage('The account has been restored. The user will now be able to login and use the dashboard.');
        } else {
            $user->update(['is_suspended' => true]);
            return redirect()->route('manage.user.index')
                ->withMessage('The account has been suspended. The user will not be able to login.');
        }
    }
}
