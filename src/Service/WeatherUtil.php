<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\City;
use App\Entity\Forcast;
use App\Repository\CityRepository;
use App\Repository\ForcastRepository;

class WeatherUtil
{
    public function __construct(
        private readonly CityRepository $cityRepository,
        private readonly ForcastRepository $forcastRepository,
    )
    {
    }
    /**
     * @return Forcast[]
     */
    public function getWeatherForLocation(City $location): array
    {
        $measurements = $this->forcastRepository->findByLocation($location);
        return $measurements;
    }

    /**
     * @return Forcast[]
     */
    public function getWeatherForCountryAndCity(string $countryCode, string $city): array
    {
        $location = $this->cityRepository->findOneBy([
            'iso' => $countryCode,
            'name' => $city,
        ]);

        $measurements = $this->getWeatherForLocation($location);

        return $measurements;
    }
}
