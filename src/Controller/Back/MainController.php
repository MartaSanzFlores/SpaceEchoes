<?php

namespace App\Controller\Back;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/back/", name="back_home")
     */
    public function index( UserRepository $userRepository): Response
    {   
        $userCount = $userRepository->getCountUser();
        $userCountToday = $userRepository->getCountUserToday();
        
        return $this->render('back/main/index.html.twig', [
            'userCount' => $userCount,
            'userCountToday' => $userCountToday,
        ]);
    }

    /**
     * @Route("/back/profile", name="back_profile")
     */
    public function profile(): Response
    {   
        $userId = $this->getUser()->getId();
        
        return $this->redirectToRoute('back_user_show', ['id' => $userId]);
    }
}
 