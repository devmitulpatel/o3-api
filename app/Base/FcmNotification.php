<?php

namespace App\Base;

use App\Traits\Makeable;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;
use NotificationChannels\Fcm\Resources\Notification;

class FcmNotification
{
    use Makeable;

    /** @var \NotificationChannels\Fcm\FcmMessage */
    private $fcmMessage;

    /** @var \NotificationChannels\Fcm\Resources\Notification */
    private $notification;

    /** @var \NotificationChannels\Fcm\Resources\AndroidConfig */
    private $androidConfig;

    /** @var \NotificationChannels\Fcm\Resources\ApnsConfig */
    private $apnsConfig;

    public function __construct()
    {
        $this->fcmMessage = FcmMessage::create();
        $this->notification = Notification::create();
        $this->androidConfig = AndroidConfig::create();
        $this->apnsConfig = ApnsConfig::create();
    }

    /**
     * @return \NotificationChannels\Fcm\FcmMessage
     */
    public function get()
    {
        return $this->fcmMessage
            ->setNotification($this->notification)
            ->setAndroid($this->androidConfig)
            ->setApns($this->apnsConfig);
    }

    public function data(array $data = [])
    {
        $this->fcmMessage->setData($data);

        return $this;
    }

    public function title($title)
    {
        $this->notification->setTitle($title);

        return $this;
    }

    public function body($body)
    {
        $this->notification->setBody($body);

        return $this;
    }

    public function image($url)
    {
        $this->notification->setImage($url);

        return $this;
    }

    public function analyticsLabel($label)
    {
        $this->androidConfig->setFcmOptions(
            AndroidFcmOptions::create()->setAnalyticsLabel($label)
        );

        $this->apnsConfig->setFcmOptions(
            ApnsFcmOptions::create()->setAnalyticsLabel($label)
        );

        return $this;
    }

    public function color($hex)
    {
        $this->androidConfig->setNotification(
            AndroidNotification::create()->setColor($hex)
        );

        return $this;
    }
}
