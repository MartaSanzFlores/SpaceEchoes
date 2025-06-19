<?php

namespace App\Controller\Back;

use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/back/review')]
class ReviewController extends AbstractController
{
    #[Route('/', name: 'back_review', methods: ['GET'])]
    public function index(ReviewRepository $reviewRepository): Response
    {
        return $this->render('back/review/index.html.twig', [
            'reviews' => $reviewRepository->getReviewsReported(),
        ]);
    }

    #[Route('/{id}', name: 'back_review_show', methods: ['GET'])]
    public function show(Review $review): Response
    {
        return $this->render('back/review/show.html.twig', [
            'review' => $review,
        ]);
    }

   #[Route('/{id}', name: 'back_review_delete', methods: ['POST'])]
    public function delete(Request $request, Review $review, ReviewRepository $reviewRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$review->getId(), $request->request->get('_token'))) {
            $reviewRepository->remove($review, true);
        }

        return $this->redirectToRoute('back_review', [], Response::HTTP_SEE_OTHER);
    }
}
