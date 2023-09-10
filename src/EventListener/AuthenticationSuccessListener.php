<?php

namespace App\EventListener;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;

class AuthenticationSuccessListener
{
    /**
    * method to add data to JWT response
    * @param AuthenticationSuccessEvent $event
    */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        // si l'utilisateur n'existe pas on sort de la fonction
        if (!$user instanceof User) {
            return;
        }

        // on stocke les données dans un tableau data[]
        $data['data'] = array(
            'roles' => $user->getRoles(),
            'username' => $user->getUserIdentifier()
        );

        $event->setData($data);
    }
}