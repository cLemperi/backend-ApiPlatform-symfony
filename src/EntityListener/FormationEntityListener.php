<?php

namespace App\EntityListener;

use App\Entity\Formations;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\ORM\Events;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;

#[AsEntityListener(event: Events::prePersist, entity:Formations::class)]
#[AsEntityListener(event: Events::preUpdate, entity:Formations::class)]
class FormationsEntityListener
{
    public function __construct(
        private SluggerInterface $slugger,
        private Security $security)
    {

    }


    public function prePersist(Formations $Formations, LifecycleEventArgs $event): void
    {
        $Formations->computeSlug($this->slugger);
    }

    public function preUpdate(Formations $Formations, LifecycleEventArgs $event): void 
    {
        $Formations->computeSlug($this->slugger);
    }

}