<?php

namespace App\Mail;

use App\Models\Group;
use App\Models\Participant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AssignmentMail extends Mailable
{
    use Queueable, SerializesModels;

    public Group $group;
    public Participant $giver;
    public Participant $receiver;
    public string $publicUrl;

    public function __construct(Group $group, Participant $giver, Participant $receiver)
    {
        $this->group = $group;
        $this->giver = $giver;
        $this->receiver = $receiver;
        $this->publicUrl = config('app.frontend_url') . '/p/' . $giver->token;
    }

    public function build()
    {
        return $this->subject("Amic Invisible - {$this->group->name}")
            ->view('mail.assignment');
    }
}
