<?php

namespace App\Mail;

use App\Models\Exam;
use App\Models\Link;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class ExamMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(private Exam $exam, private User $user)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Exam Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $invitationBody =['email'=>$this->user->email,'exam_id'=>$this->exam->id];
        $invitationBodyencoded = base64_encode(json_encode($invitationBody));
        // dd($invitationBodyencoded);
        $uniqueUrl = URL::signedRoute('exam.fill', ['token'=>$invitationBodyencoded]);

       
        Link::updateOrCreate(['url'=> $uniqueUrl,'user_id'=>$this->user->id,'exam_id'=>$this->exam->id]);

        return new Content(
            markdown: 'mail.exam',
            with: [
                'exam' => $this->exam,
                'url'=>$uniqueUrl,
                'user' =>$this->user
            ],
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
