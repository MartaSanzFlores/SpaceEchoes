<?php

namespace App\Controller\Api;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LogoutController extends AbstractController
{


    #[Route('/api/logout', name:'api_logout')]
    public function logout(): Response
    {
        // TODO desactiver le Token JWT
        
        return $this->json([
            'message' => 'Logout success',
        ]);
    }
}
