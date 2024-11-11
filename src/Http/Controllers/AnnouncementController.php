<?php

namespace Uneca\DisseminationToolkit\Http\Controllers;

use App\Http\Controllers\Controller;
use Uneca\DisseminationToolkit\Http\Requests\AnnouncementRequest;
use Uneca\DisseminationToolkit\Models\Announcement;
use Uneca\DisseminationToolkit\Models\User;
use Uneca\DisseminationToolkit\Notifications\BroadcastMessageNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\MessageBag;
use Spatie\Permission\Models\Role;

class AnnouncementController extends Controller
{
    public function index()
    {
        $records = Announcement::paginate(config('dissemination.records_per_page'));
        return view('dissemination::announcement.index', compact('records'));
    }

    private function recipientsList()
    {
        return Role::whereNotIn('name', ['Super Admin'])
            ->pluck('name', 'id')
            ->map(fn ($role) => "Users having $role role")
            ->prepend('Everyone', 0)
            ->all();
    }

    public function create()
    {
        $recipients = $this->recipientsList();
        return view('dissemination::announcement.create', compact('recipients'));
    }

    public function store(AnnouncementRequest $request)
    {
        $sender = auth()->user();
        $recipients = $request->integer('recipients');
        $recipientUsers = match ($recipients) {
            0 => User::whereKeyNot($sender->id)->get(),
            default => Role::find($recipients)->users,
        };
        if ($recipientUsers->count() > 0) {
            $recipientsList = $this->recipientsList();
            $announcement = auth()->user()
                ->announcements()
                ->create(array_merge($request->safe()->all(), ['recipients' => $recipientsList[$recipients]]));
            try {
                Notification::sendNow($recipientUsers, new BroadcastMessageNotification($announcement));
            } catch (\Exception $exception) {
                //
            }
            return redirect()->route('manage.announcement.index')->withMessage('The announcement has been sent to the specified recipients group.');
        }
        return redirect()->route('manage.announcement.index')->withErrors(new MessageBag(['No users found for specified recipients group.']));
    }
}
