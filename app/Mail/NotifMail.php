<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifMail extends Mailable
{
    use Queueable, SerializesModels;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;
    public $text_subject;

    public function __construct(array $data, String $subject)
    {
        $this->data = [
            'title'     => $data['title'],
            'header'    => $data['header'] ?? '',
            'content'   => $data['content'],
            'footer'    => $data['footer'] ?? 'seminar.co.id'
        ];
        $this->text_subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->text_subject)->view('emails.notif-mail', $this->data);
        // return $this->view('view.name');
    }
}
