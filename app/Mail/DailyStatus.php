<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Task;

class DailyStatus extends Mailable
{
    use Queueable, SerializesModels;
    public $tasks;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $tasks=Task::whereIn('status',['To do','In progress'])->where('is_active',1)->whereNull('deleted_at')->get();
        $this->tasks=$tasks;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Prohori - Alert - Unresolved Tasks')->view('emails.daily-status');
    }
}
