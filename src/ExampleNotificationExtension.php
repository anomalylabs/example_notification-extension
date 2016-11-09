<?php namespace Anomaly\ExampleNotificationExtension;

use Anomaly\ExampleNotificationExtension\Notification\ExampleNotification;
use Anomaly\NotificationsModule\Notification\NotificationExtension;
use Anomaly\UsersModule\User\Event\UserWasLoggedIn;

/**
 * Class ExampleNotificationExtension
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ExampleNotificationExtension extends NotificationExtension
{

    /**
     * The notification event.
     *
     * @var null|string
     */
    public $event = UserWasLoggedIn::class;

    /**
     * The supported drivers.
     *
     * @var array
     */
    protected $supported = [
        'mail',
        'slack',
    ];

    /**
     * This extension provides an example
     * notification for the notifications module.
     *
     * @var string
     */
    protected $provides = 'anomaly.module.notifications::notification.example';

    /**
     * Return a new notification.
     *
     * @param $event
     * @throws \Exception
     */
    public function newNotification($event)
    {
        return new ExampleNotification($event);
    }
}
