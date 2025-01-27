<?php
namespace App\Mail;

use App\Models\PropertyMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PropertyMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $message;
    public $user_name;
    public $property_name;
    public $subject;
    public $message_content;
    public $loginRoute;

    /**
     * Create a new message instance.
     */
    public function __construct(PropertyMessage $message, string $user_name, string $property_name, string $subject, string $message_content, string $loginRoute)
    {
        $this->message = $message;
        $this->user_name = $user_name;
        $this->property_name = $property_name;
        $this->subject = $subject;
        $this->message_content = $message_content;
        $this->loginRoute = $loginRoute;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Message Regarding Your Property: ' . $this->property_name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.property_message',
            with: [
                'user_name' => $this->user_name,
                'property_name' => $this->property_name,
                'subject' => $this->subject,
                'message_content' => $this->message_content,
                'loginRoute' => $this->loginRoute
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
