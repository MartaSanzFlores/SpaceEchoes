<?php

namespace App\Controller\Api;

use App\Entity\Post;
use App\Entity\Review;
use App\Repository\ReviewRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReviewController extends AbstractController
{

    #[Route('/api/secure/posts/{id<\d+>}/review', name:'api_review', methods:['POST'])]
    public function new(Request $request, ReviewRepository $reviewRepository, Post $post): JsonResponse
    {
        // on recupère le contenu de la requette vers l'api et on transforme le json en objet/array PHP
        $response = json_decode($request->getContent(), true);

        // on recupere le contenu du commentaire
        $content = $response['content_review'];

        // si le contenu de commentaire est vide ou n'existe pas on envoie un message d'erreur
        if (empty($content) || !isset($content)) {
            return $this->json([
                'message' => 'Request content is empty or missing'
            ], 400);
        }

        // on crée une instance de la clase Review
        $review = new Review;

        // on hydrate l'instance
        $review->setContent($content);
        $review->setUserReview($this->getUser());
        $review->setPost($post);

        // on sauvegarde l'entité review (persist et flush)
        $reviewRepository->add($review, true);

        // on return un message de success
        return $this->json([
            'message' => 'success saving data'
        ]);
    }

    #[Route('/api/secure/posts/review/{id<\d+>}', name:'api_review_edit', methods:['PATCH'])]
    public function edit(Request $request, ReviewRepository $reviewRepository, Review $review): JsonResponse
    {
        // on recupère le contenu de la requette vers l'api et on transforme le json en objet/array PHP
        $response = json_decode($request->getContent(), true);

        // on recupere le contenu du commentaire
        $content = $response['content_review'];

        // si le contenu de commentaire est vide ou n'existe pas on envoie un message d'erreur
        if (empty($content) || !isset($content)) {
            return $this->json([
                'message' => 'Request content is empty or missing'
            ], 400);
        }

        // on hydrate l'instance
        $review->setContent($content);

        // on sauvegarde l'entité review (persist et flush)
        $reviewRepository->add($review, true);

        // on return un message de success
        return $this->json([
            'message' => 'success saving data'
        ]);
    }

    #[Route('/api/secure/posts/review/{id<\d+>}', name:'api_review_delete', methods:['DELETE'])]
    public function delete(ReviewRepository $reviewRepository, Review $review): JsonResponse
    {
        // on sauvegarde l'entité review (persist et flush)
        $reviewRepository->remove($review, true);

        // on return un message de success
        return $this->json([
            'message' => 'success deleting data'
        ]);
    }

    #[Route('/api/secure/posts/review/{id<\d+>}/report', name:'api_review_report', methods:['POST'])]
    public function report(ReviewRepository $reviewRepository, Review $review): JsonResponse
    { 
        // on recupere l'utilisateur connecté
        $user = $this->getUser();
        // on recupere la collection des utilisateurs qui ont deja signalé ce commentaire
        $users_report = $review->getUsersReports();

        // on envoie un message d'erreur si l'utilisateur a déja signalé le commentaire
        if (in_array($user, $users_report->toArray()) ) {
            return $this->json([
                'message' => 'This user has already reported this review'
            ], 400);
        }

        // on hydrate l'instance
        $review->addUsersReport($user);

        // on sauvegarde l'entité review (persist et flush)
        $reviewRepository->add($review, true);

        // on return un message de success
        return $this->json([
            'message' => 'Review reported',
        ]);
    }
}
