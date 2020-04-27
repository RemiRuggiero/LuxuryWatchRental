<?php

namespace App\Event;

use App\Entity\Picture;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use App\Entity\User;
use App\Entity\WatchModel;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminSubscriber implements EventSubscriberInterface
{
    private $encoder;

    public function __construct( UserPasswordEncoderInterface $encoder )
    {
        $this->encoder = $encoder;
        
    }

    public static function getSubscribedEvents()
    {
        return array(
            'easy_admin.pre_persist' => array( 'prepersist'),
            'easy_admin.pre_update' => array( 'getAllPictures'),
        
        );
    }

    public function prepersist( GenericEvent $event )
    {
        $this->encodeUserPassword($event);
        $this->getAllPictures($event);
    }

    public function encodeUserPassword( GenericEvent $event )
    {
        $entity = $event->getSubject();

        if (!($entity instanceof User)) {
            return;
        }

        $plain = $entity->getPlainPassword();
        $password = $this->encoder->encodePassword( $entity, $plain );
        $entity->setPassword( $password );

        $event['entity'] = $entity;
    }

    public function getAllPictures( GenericEvent $event )
    {
        $entity = $event->getSubject();

        if (!($entity instanceof WatchModel)) {
            return;
        }

        $allPicture = $entity->getPictures();  
        foreach($allPicture as $picture)
        {
            $picture->setWatchModel($entity);
        }
        $allEntities = $entity->getWatchEntities();  
        foreach($allEntities as $e)
        {
            $e->setWatchModel($entity);
        }           
        
        $event['entity'] = $entity;

    
    }
}