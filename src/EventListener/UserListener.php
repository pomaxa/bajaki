<?php


namespace App\EventListener;

use App\Entity\User;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\Argon2iPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class UserListener
{
    /**
     * @var Argon2iPasswordEncoder
     */
    private $passwordEncoder;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof User) {
            $plainPassword = $entity->getPlainPassword();
            if(!empty($plainPassword)) {
                $encoder = $this->encoderFactory ->getEncoder($entity);
                $password = $encoder->encodePassword($plainPassword, $entity->getId());
                $entity->setPassword($password);
            }
        }
    }
}
