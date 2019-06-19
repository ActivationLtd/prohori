<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AssignmentCreated extends Mailable
{
    use Queueable, SerializesModels;
    public $assignment;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($assignment)
    {
        //
        $this->assignment = $assignment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->assignment->task->tasktype_name . " for " . $this->assignment->task->client_name . "- has been assigned to ".$this->assignment->task->assignee->name)->view('emails.assignment-created');
    }
}
