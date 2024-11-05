<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CityController extends AbstractController
{

    #[Route('/city/{name}/{latitude}/{longitude}', name: 'app_city_show')]
    public function show(ManagerRegistry $doctrine, $name, $latitude, $longitude): Response {

        if ($this->isGranted('ROLE_PREMIUM')) {
            return $this->render('city/premium.html.twig', [
                'controller_name' => 'CityController',
                'name' => $this->formatCityName($name),
                'latitude' => $latitude,
                'longitude' => $longitude
            ]);
        }
        return $this->render('city/show.html.twig', [
            'controller_name' => 'CityController',
            'name' => $this->formatCityName($name),
            'latitude' => $latitude,
            'longitude' => $longitude
        ]);
    }
    function formatCityName($cityName) {
        // Remplacer "l-" ou "-l-" par "l'" sans espace, sinon remplace les tirets par des espaces
        $formattedName = preg_replace("/\b-l-\b/", "-l'", $cityName);
        $formattedName = str_replace('-', ' ', $formattedName);

        // Mettre en majuscules
        $formattedName = strtoupper($formattedName);

        return $formattedName;
    }
}
