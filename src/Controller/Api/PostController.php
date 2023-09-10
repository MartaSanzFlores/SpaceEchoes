<?php

namespace App\Controller\Api;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * Get Post collection
     * @Route("/api/posts", name="api_posts", methods={"GET"})
     */
    public function getCollectionPost(PostRepository $postRepository): JsonResponse
    {
        //on utilise la méthode getPublishedPosts() de PostRepository pour lister tous les articles 
        $posts = $postRepository->getPublishedPosts();

        //on retourne la liste d'articles en format json 
        //cet liste d'articles est retourné dans un tableau en suivant les règles de securité OWASP

        return $this->json(
            // 1er parametres = ce qu'on veut afficher
            $posts,
            // 2eme parametre : le code status
            // voir liste des code status : https://en.wikipedia.org/wiki/List_of_HTTP_status_codes
            200,
            // 3eme parametre = le header
            [],
            // 4eme parametre : le/les groupe(s)
            // Les groupes permettent de définir quels éléments de l'entité on veut afficher
            ['groups' => 'get_collection_post']
        );

    }
}
