<?php


namespace App\EventListener;

use App\Entity\User;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserListener
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof User) {
            $plainPassword = $entity->getPlainPassword();
            if(!empty($plainPassword)) {
                $password = $this->passwordEncoder->encodePassword($entity, $plainPassword);
                $entity->setPassword($password);
            }
        }
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof User) {
            $plainPassword = $entity->getPlainPassword();
            if(!empty($plainPassword)) {
                $password = $this->passwordEncoder->encodePassword($entity, $plainPassword);
                $entity->setPassword($password);
            }
        }
    }
}
