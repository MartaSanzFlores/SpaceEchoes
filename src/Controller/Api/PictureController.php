<?php

namespace App\Controller\Api;

use App\Entity\Picture;
use App\Repository\PictureRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PictureController extends AbstractController
{

    #[Route('/api/pictures', name:'api_pictures', methods:['GET'])]
    public function getCollectionPicture(PictureRepository $pictureRepository): JsonResponse
    {
        //on utilise la méthode getPublishedGallery() crée dans PictureRepository pour lister tous les images
        $pictures = $pictureRepository->getPublishedGallery();

        //on retourne la liste d'articles en format json
        //cet liste d'images est retourné dans un tableau en suivant les règles de securité OWASP
        return $this->json(
            // 1er parametres = ce qu'on veut afficher
            $pictures,
            // 2eme parametre : le code status
            // voir liste des code status : https://en.wikipedia.org/wiki/List_of_HTTP_status_codes
            200,
            // 3eme parametre = le header
            [],
            // 4eme parametre : le/les groupe(s)
            // Les groupes permettent de définir quels éléments de l'entité on veut afficher
            ['groups' => 'get_collection_picture']
        );
    }

    #[Route('/api/secure/pictures/{id<\d+>}/like', name:'api_picture_like', methods:['POST'])]
    public function likePicture(Picture $picture, PictureRepository $pictureRepository): JsonResponse
    {
        // on recupère toutes les images de la galerie
        $gallery = $pictureRepository->findGalleryPublishedPictures();

        // si l'image n'appartient pas à la galerie, l'image ne peut pas être liké
        if(!in_array($picture, $gallery)){
            return $this->json([
                'message' => 'Can\'t like this picture'
            ], 400);
        }

        // on hydrate l'instance
        $picture->addUsersLike($this->getUser());

        // on sauvegarde l'entité picture (persist et flush)
        $pictureRepository->add($picture, true);

        // on return un message de success
        return $this->json([
         'message' => 'success saving data'
        ]);
    }


    #[Route('/api/secure/pictures/{id<\d+>}/remove_like', name:'api_picture_remove_like', methods:['POST'])]
    public function removeLikePicture(Picture $picture, PictureRepository $pictureRepository): JsonResponse
    {
        // on supprime le like de l'instance
        $picture->removeUsersLike($this->getUser());

        // on sauvegarde l'entité picture (persist et flush)
        $pictureRepository->add($picture, true);

        // on return un message de success
        return $this->json([
         'message' => 'success remove data'
        ]);
    }
}
