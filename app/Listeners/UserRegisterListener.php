<?php
namespace App\Listeners;

// TODO: Fix this xdebug max nesting function Bug.
ini_set('xdebug.max_nesting_level', 500);

use App\Events\UserRegistered;
use App\Notification;
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

        $this->notifyAll($user);
    }

    /**
     * Sends Mail
     * @param $user
     */
    public function welcome($user)
    {
        $this->mailer->sendTo($user,"Confirm your Email KnightofSorrow.in Swat4 Community & Servers",'emails.welcome',['user' => $user]);
    }

    public function notifyAll($user)
    {
        $not = new Notification();
        $not->from($user)
            ->withType('UserRegistered')
            ->withSubject('A new user registration')
            ->withBody("A new user registered : ".link_to_route('user.show',$user->displayName(),[$user->username]))
            ->withStream(true)
            ->regarding($user)
            ->deliver();
    }
}