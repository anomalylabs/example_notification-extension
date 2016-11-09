<?php namespace Anomaly\ExampleNotificationExtension\Notification;

use Anomaly\NotificationsModule\Channel\Traits\SendsViaChannel;
use Anomaly\NotificationsModule\Subscription\Contract\SubscriptionInterface;
use Anomaly\Streams\Platform\Notification\Message\MailMessage;
use Anomaly\UsersModule\User\Event\UserWasLoggedIn;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackAttachment;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

/**
 * Class ExampleNotification
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ExampleNotification extends Notification implements ShouldQueue
{

    use Queueable;
    use SendsViaChannel;

    /**
     * The event instance.
     *
     * @var UserWasLoggedIn
     */
    protected $event;

    /**
     * Create a new ExampleNotification instance.
     *
     * @param UserWasLoggedIn $event
     */
    public function __construct(UserWasLoggedIn $event)
    {
        $this->event = $event;
    }

    /**
     * Return the mail message.
     *
     * @param SubscriptionInterface $notifiable
     * @return MailMessage
     */
    public function toMail(SubscriptionInterface $notifiable)
    {
        return $notifiable->format(
            (new MailMessage())
                ->subject('Example Notification')
                ->line('@' . $this->event->getUser()->getUsername() . ' has logged in to ' . url('/'))
                ->action(
                    'View Profile',
                    url($this->event->getUser()->route('view'))
                )
        );
    }

    /**
     * Return the slack message.
     *
     * @param SubscriptionInterface $notifiable
     * @return SlackMessage
     */
    public function toSlack(SubscriptionInterface $notifiable)
    {
        return $notifiable->format(
            (new SlackMessage())
                ->content('@' . $this->event->getUser()->getUsername() . ' has logged in to ' . url('/'))
                ->attachment(
                    function (SlackAttachment $attachment) {
                        $attachment->title('View Profile', url($this->event->getUser()->route('view')));
                    }
                )
        );
    }
}
