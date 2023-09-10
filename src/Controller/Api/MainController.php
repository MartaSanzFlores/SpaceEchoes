<?php

namespace App\Controller\Api;

use App\Repository\PictureRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/api/", name="api_home")
     */
    public function home(PostRepository $postRepository, PictureRepository $pictureRepository): JsonResponse
    {
        //on utilise la méthode findRecentPosts() de PostRepository pour lister les 3 articles les plus récents
        $recentPosts = $postRepository->findRecentPosts();
        $popularPictures = $pictureRepository->findPopularPictures();

        return $this->json(
            // 1er parametre = ce qu'on veut afficher
            [$recentPosts, $popularPictures],
            // 2eme parametre : le code status
            // voir liste des code status : https://en.wikipedia.org/wiki/List_of_HTTP_status_codes
            200,
            // 3eme parametre = le header
            [],
            // 4eme parametre : les groupes
            // Les groupes permettent de définir quels éléments de l'entité on veut afficher
            ['groups' => ['get_collection_post', 'get_collection_picture']]
        );
    }
}
