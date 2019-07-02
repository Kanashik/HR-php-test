<?php
namespace App\Weather;

use App\City;
use App\Exceptions\WeatherClientApiException;

/**
 * Интерфейс для клиентов, получающих данные о погоде.
 *
 * @package App\Weather
 */
interface WeatherApiClientInterface
{
	/**
	 * Получает данные о текущей погоде.
	 *
	 * @param City $city Город
	 *
	 * @return WeatherFactData Объект, содержащий данные о погоде
	 *
	 * @throws WeatherClientApiException
	 */
	public function getFactData(City $city): WeatherFactData;
}