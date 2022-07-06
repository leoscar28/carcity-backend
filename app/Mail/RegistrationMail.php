<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationMail extends Mailable
{
    use Queueable, SerializesModels;
    public string $name;
    public string $title;
    public string $text;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $name = '', string $title = '', string $text = '')
    {
        $this->name =   $name;
        $this->title    =   $title;
        $this->text =   $text;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this->view('mail-reg',[
            'name'  =>  $this->name,
            'title' =>  $this->title,
            'text'  =>  $this->text,
        ])->subject($this->title);
    }
}
