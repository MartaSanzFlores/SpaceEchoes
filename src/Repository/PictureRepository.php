<?php

namespace App\Repository;

use App\Entity\Picture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Picture>
 *
 * @method Picture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Picture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Picture[]    findAll()
 * @method Picture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PictureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Picture::class);
    }

    public function add(Picture $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Picture $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Get gallery pictures
     * @return array
     */
    public function findGalleryPublishedPictures()
    {
        $entityManager = $this->getEntityManager();
        // requette pour recupérer les images de la gallery (gallery = true) dont la date de publication est anterieure ou egal à la date actuel
        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Picture AS p
            WHERE p.galery = 1
            AND p.publishedAt <= :today'
        )->setParameter('today', new \DateTimeImmutable());

        // retourne un tableau d'objet Picture
        return $query->getResult();
    }

    /**
     * Get gallery pictures and likes
     * @return array
     */
    public function getPublishedGallery()
    {
        //on utilise la methode findGalleryPublishedPictures() crée dans ce repository pour recuperer la liste d'images de la galerie
        $pictures = $this->findGalleryPublishedPictures();

        //on initialise un tableau pour stocker les résultats de la boucle foreach
        $likes = [];
        //on parcoure la liste des images et pour chaque image on compte le nombre de likes qui la correspond
        foreach ($pictures as $picture) {
            $likesNumber = count($picture->getUsersLikes());
            //on initialise un tableau pour grouper chaque image avec son nombre de likes [picture ,LikesNumber]
            $array = [];
            //on rempli le tableau 
            $array['picture'] = $picture;
            $array['likesNumber'] = $likesNumber;

            array_push($likes, $array);
        }

        return $likes;
    }


    /**
     * Get popular pictures
     * @return array
     */
    public function findPopularPictures()
    {
        //on utilise la methode findGalleryPublishedPictures() crée dans ce repository pour recuperer la liste d'images de la galerie
        $pictures = $this->findGalleryPublishedPictures();
        
        //on initialise un tableau pour stocker les résultats de la boucle foreach
        $popularPictures = [];
        // TODO: optimiser le code répéter
        //on parcoure la liste des images et pour chaque image on compte le nombre de likes qui la correspond
        foreach ($pictures as $picture) {
            
            $likesNumber = count($picture->getUsersLikes());
            //on initialise un tableau pour grouper chaque image avec son nombre de likes [picture ,LikesNumber]
            $array = [];
            //on rempli le tableau 
            $array['picture'] = $picture;
            $array['likesNumber'] = $likesNumber;

            array_push($popularPictures, $array);
        }

        // on indique la clé de notre tableau $popularPictures qu'on veut utiliser pour l'ordonér
        $key_values = array_column($popularPictures, 'likesNumber'); 
        // on utilise la fucntion array_multisort() de php pour ordoner notre tableau par nombre de likes descendent
        array_multisort($key_values, SORT_DESC, $popularPictures);

        // on utilise la function array_slice() de php pour stockér seulement les 4 images qui ont plus de likes
        $popularPictures = array_slice($popularPictures, 0, 4);
        
        return $popularPictures;
    }

}
