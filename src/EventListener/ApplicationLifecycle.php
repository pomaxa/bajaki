<?php


namespace App\EventListener;
use Doctrine\ORM\Event\LifecycleEventArgs;

class ApplicationLifecycle
{

    public function preUpdate(LifecycleEventArgs $event)
    {
        if ($event->hasChangedField('username')) {
            // Do something when the username is changed.
        }
    }

}