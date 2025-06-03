<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $view;
    public $contents;

    public function __construct($subject, $view, $contents)
    {
        $this->subject = $subject;
        $this->view = $view;
        $this->contents = $contents;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: $this->view,
            with: $this->contents
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

