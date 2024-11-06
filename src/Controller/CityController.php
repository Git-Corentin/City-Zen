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
        $country = $this->findCountry(strtoupper($country));
        $data_currencies = json_decode(file_get_contents('json_files/country-by-currency-code.json'), true);
        dump($data_currencies);
        $list_currencies = array_unique(array_column($data_currencies, 'currency_code'));
        dump($list_currencies);
        return $this->render('city/show.html.twig', [
            'controller_name' => 'CityController',
            'country' => $country,
            'flag' => $this->findSomeData($country, 'json_files/country-by-flag.json', 'flag_base64'),
            'currency' => $this->findSomeData($country, 'json_files/country-by-currency-name.json', 'currency_name'),
            'currency_code' => $this->findSomeData($country, 'json_files/country-by-currency-code.json', 'currency_code'),
            'currency_codes' => $list_currencies,
            'capital' => $this->findSomeData($country, 'json_files/country-by-capital-city.json', 'city'),
            'continent' => $this->findSomeData($country, 'json_files/country-by-continent.json', 'continent'),
            'government' => $this->findSomeData($country, 'json_files/country-by-government-type.json', 'government'),
            'population' => $this->findSomeData($country, 'json_files/country-by-population.json', 'population').' habitants',
            'density' => $this->findSomeData($country, 'json_files/country-by-population-density.json', 'density').' habitants/km²',
            'languages' => implode(', ', $this->findSomeData($country, 'json_files/country-by-languages.json', 'languages')),
            'life_expectancy' => $this->findSomeData($country, 'json_files/country-by-life-expectancy.json', 'expectancy').' ans',
            'national_dish' => $this->findSomeData($country, 'json_files/country-by-national-dish.json', 'dish'),
            'religion' => $this->findSomeData($country, 'json_files/country-by-religion.json', 'religion'),
            'surface' => $this->findSomeData($country, 'json_files/country-by-surface-area.json', 'area').' km²',
            'annual_temperature' => $this->findSomeData($country, 'json_files/country-by-yearly-average-temperature.json', 'temperature').'°C',
            'phone_code' => '+'.$this->findSomeData($country, 'json_files/country-by-calling-code.json', 'calling_code'),
            'name' => $this->formatCityName($name),
            'latitude' => $latitude,
            'longitude' => $longitude
        ]);
    }
    function findCountry($country) {
        $countryByAbbreviation = json_decode(file_get_contents('json_files/country-by-abbreviation.json'), true);
        $countryData = null;
        foreach ($countryByAbbreviation as $large_country) {
            if ($large_country['abbreviation'] === $country) { // Vous pouvez ajuster cette logique en fonction de votre entrée
                $countryData = $large_country;
                break;
            }
        }
        return $countryData['country'];
    }


    function findSomeData($country, $jsonFile, $key) {
        $data = json_decode(file_get_contents($jsonFile), true);
        $dataFound = null;
        foreach ($data as $item) {
            if ($item['country'] === $country) {
                $dataFound = $item;
                break;
            }
        }
        dump($dataFound);
        return $dataFound[$key];
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
