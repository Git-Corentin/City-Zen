<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CityController extends AbstractController
{

    #[Route('/city/{country}/{name}/{latitude}/{longitude}', name: 'app_city_show')]
    public function show(ManagerRegistry $doctrine, $name, $latitude, $longitude, $country): Response {
        dump($country);
        return $this->render('city/show.html.twig', [
            'controller_name' => 'CityController',
            'country' => $country,
            'currency' => $this->findCurrency(strtoupper($country)),
            'name' => $this->formatCityName($name),
            'latitude' => $latitude,
            'longitude' => $longitude
        ]);
    }

    function findCurrency($country) {
        // Charger les fichiers JSON
        $countryByAbbreviation = json_decode(file_get_contents('json_files/country-by-abbreviation.json'), true);
        $countryByCurrencyName = json_decode(file_get_contents('json_files/country-by-currency-name.json'), true);

        // Trouver le pays correspondant à l'abréviation
        $countryData = null;
        foreach ($countryByAbbreviation as $large_country) {
            if ($large_country['abbreviation'] === $country) { // Vous pouvez ajuster cette logique en fonction de votre entrée
                $countryData = $large_country;
                break;
            }
        }


        // Trouver la monnaie associée au pays
        $currencyData = null;
        if ($countryData) {
            foreach ($countryByCurrencyName as $currency) {
                if ($currency['country'] === $countryData['country']) {
                    $currencyData = $currency;
                    break;
                }
            }
        }
        dump($currencyData);
        return $currencyData['currency_name'];
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
