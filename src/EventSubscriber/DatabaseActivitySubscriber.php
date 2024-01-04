<?php

namespace App\EventSubscriber;

use App\Entity\Product;
use App\Entity\Category;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\PostRemoveEventArgs;
use Symfony\Component\HttpKernel\KernelInterface;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;

class DatabaseActivitySubscriber implements EventSubscriberInterface
{
    private $appKernel;
    
    public function __construct(KernelInterface $k)
    {
        $this->appKernel = $k;
    }

    public  function getSubscribedEvents(): array
    {
        return [//tableau qui contient les éléments qu'on veut intercepter
            Events::postRemove,
        ];
    }

    public function postRemove(PostRemoveEventArgs $args):void{
        $this->logActivity('remove', $args->getObject());
    }

    public function logActivity(String $action, mixed $entity):void{
        $fileLink = $this->appKernel->getProjectDir()."/public/assets/images/";
        
        if(($entity instanceof Product) && $action === "remove"){
            try{
                $filesName = $entity->getImagesUrl();
                foreach($filesName as $img){
                    unlink($fileLink.'products/'.$img);
                }
            }catch(\Throwable $th){}
        }
        if(($entity instanceof Category) && $action === "remove"){
            try{
                $filesName = $entity->getImageUrl();
                unlink($fileLink.'categories/'.$filesName);
            }catch(\Throwable $th){}
        }
    }
}
