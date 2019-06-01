<?php


namespace App\EventListener;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class ApplicationLifecycle
{

    public function preUpdate(PreUpdateEventArgs $event)
    {
        if ($event->hasChangedField('username')) {
            // Do something when the username is changed.
        }
    }

}