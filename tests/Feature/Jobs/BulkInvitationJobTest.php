<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Uneca\DisseminationToolkit\Jobs\BulkInvitationJob;
use Uneca\DisseminationToolkit\Mail\InvitationMail;
use Uneca\DisseminationToolkit\Models\Invitation;
use Uneca\DisseminationToolkit\Notifications\TaskCompletedNotification;

function invitationCsvPath(array $rows): string
{
    $lines = ['email,role'];
    foreach ($rows as $row) {
        $lines[] = $row['email'].','.($row['role'] ?? '');
    }

    Storage::disk('local')->put('test/invitations.csv', implode("\n", $lines));

    return Storage::disk('local')->path('test/invitations.csv');
}

it('creates invitations from a csv file and sends emails', function () {
    Mail::fake();
    Notification::fake();

    $path = invitationCsvPath([
        ['email' => 'invited-one@example.org', 'role' => 'Manager'],
        ['email' => 'invited-two@example.org', 'role' => 'Contributor'],
    ]);

    BulkInvitationJob::dispatch($path, true, adminUser());

    expect(Invitation::count())->toBe(2)
        ->and(Invitation::pluck('email')->all())->toContain('invited-one@example.org', 'invited-two@example.org');

    Mail::assertQueued(InvitationMail::class, 2);
    Notification::assertSentTo(adminUser(), TaskCompletedNotification::class);
});

it('can create invitations without sending emails', function () {
    Mail::fake();
    Notification::fake();

    $path = invitationCsvPath([
        ['email' => 'invited-three@example.org'],
    ]);

    BulkInvitationJob::dispatch($path, false, adminUser());

    expect(Invitation::count())->toBe(1);
    Mail::assertNothingQueued();
});

it('skips invalid rows and reports the result', function () {
    Mail::fake();
    Notification::fake();

    $path = invitationCsvPath([
        ['email' => 'invited-four@example.org'],
        ['email' => 'not-an-email'],
        ['email' => 'super@example.org'], // already a user
    ]);

    BulkInvitationJob::dispatch($path, false, adminUser());

    expect(Invitation::where('email', 'invited-four@example.org')->exists())->toBeTrue()
        ->and(Invitation::count())->toBe(1);

    Notification::assertSentTo(adminUser(), TaskCompletedNotification::class, function ($notification) {
        return str_contains($notification->toArray(adminUser())['body'], '1 invitations have been created from the 3 rows');
    });
});
