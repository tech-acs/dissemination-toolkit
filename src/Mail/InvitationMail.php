<?php

namespace Uneca\DisseminationToolkit\Mail;

use Uneca\DisseminationToolkit\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Invitation $invitation) {}

    public function build()
    {
        return $this->subject(config('app.name') . ' registration invitation')
            ->markdown('dissemination::mail.invitation')
            ->with(['ttl' => config('dissemination.invitation.ttl_hours')]);
    }
}
