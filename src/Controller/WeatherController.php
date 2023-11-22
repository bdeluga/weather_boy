<?php

namespace App\Controller;

use App\Entity\City;
use App\Repository\ForcastRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\WeatherUtil;

class WeatherController extends AbstractController
{
    #[Route('/weather/{name}/{iso}', name: 'app_weather' )]
    public function city(
        #[MapEntity(mapping: ['name' => 'name', 'iso' => 'iso'])
    ]
    City $city,
    WeatherUtil $util
    ): Response
    
    {
        $measurements = $util->getWeatherForLocation($city);
        return $this->render('weather/city.html.twig', [
            'location' => $city,
            'measurements' => $measurements,
    
        ]);
    }
}
