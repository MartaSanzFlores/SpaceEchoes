<?php

namespace App\Service;

use App\Repository\ReviewRepository;

class ReportNotification
{
    private $reviewRepository;

    public function __construct(ReviewRepository $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    /**
     * Get reports count from revieRepository
     */
    public function countReportsNotif()
    {
        //on appelle la methode countReviewsReported dans le ReviewRepository
        $notifCount = $this->reviewRepository->countReviewsReported();

        return $notifCount;
    }
}