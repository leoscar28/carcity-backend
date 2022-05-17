<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationMail extends Mailable
{
    use Queueable, SerializesModels;
    public string $name;
    public string $title;
    public string $text;
    public string $link;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $name = '', string $title = '', string $text = '', string $link = '')
    {
        $this->name =   $name;
        $this->title    =   $title;
        $this->text =   $text;
        $this->link =   $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this->view('mail',[
            'name'  =>  $this->name,
            'title' =>  $this->title,
            'text'  =>  $this->text,
            'link'  =>  $this->link
        ])->subject($this->title);
    }
}
