<?php

namespace App\Controller\Api;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    
    #[Route('/api/categories', name:'api_categories', methods:['GET'])]
    public function getCollectionCategory(CategoryRepository $categoryRepository): JsonResponse
    {
        //on utilise la méthode findAll() de categoryRepository pour lister tous les categories 
        $categories = $categoryRepository->findAll();

        return $this->json(
            // 1er parametres = ce qu'on veut afficher
            $categories,
            // 2eme parametre : le code status
            // voir liste des code status : https://en.wikipedia.org/wiki/List_of_HTTP_status_codes
            200,
            // 3eme parametre = le header
            [],
            // 4eme parametre : le/les groupe(s)
            // Les groupes permettent de définir quels éléments de l'entité on veut afficher
            ['groups' => 'get_collection_categories']
        );
    }
}
