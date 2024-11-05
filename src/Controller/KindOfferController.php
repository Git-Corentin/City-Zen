<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class KindOfferController extends AbstractController
{
    #[Route('/kind/offer', name: 'app_kind_offer')]
    public function index(): Response
    {
        return $this->render('offers/kind_offer.html.twig', [
            'controller_name' => 'KindOfferController',
        ]);
    }
}
