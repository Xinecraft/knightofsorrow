<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Mail;
use App\Server\Mailers\Mailer;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewMessageEmail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    /**
     * @var Mail
     */
    public $mail;
    /**
     * @var User
     */
    public $sender;
    /**
     * @var User
     */
    public $reciever;

    /**
     * Create a new job instance.
     *
     * @param Mail $mail
     * @param User $sender
     * @param User $reciever
     */
    public function __construct(Mail $mail, User $sender, User $reciever)
    {
        $this->mail = $mail;
        $this->sender = $sender;
        $this->reciever = $reciever;
    }

    /**
     * Execute the job.
     *
     * @param Mailer $mailer
     */
    public function handle(Mailer $mailer)
    {
        $subject = "You got a new message from ".$this->sender->displayName();

        $data = [
            'sender' => $this->sender,
            'reciever' => $this->reciever,
            'mail' => $this->mail
        ];
        $mailer->sendTo($this->reciever, $subject, 'emails.newmessage', $data);
    }
}
