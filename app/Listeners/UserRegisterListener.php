<?php
namespace App\Listeners;

// TODO: Fix this xdebug max nesting function Bug.
ini_set('xdebug.max_nesting_level', 500);

use App\Events\UserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Server\Mailers\Mailer;

class UserRegisterListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * Create the event listener.
     *
     * @param Mailer $mailer
     */
    public function __construct(Mailer $mailer)
    {
        //
        $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     *
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $user = $event->user;

        $this->welcome($user);
    }

    /**
     * Sends Mail
     * @param $user
     */
    public function welcome($user)
    {
        $this->mailer->sendTo($user,"Welcome to Knight of Sorrow",'emails.welcome',['user' => $user]);
    }
}