<?php
namespace App\Weather;

use App\City;
use App\Exceptions\WeatherClientApiException;

/**
 * Клиент, реализующий работу с API Яндекс.Погоды.
 *
 * @package App\Weather
 */
class YandexWeatherApiClient implements WeatherApiClientInterface
{
	/**
	 * @var string Url для запросов к API
	 */
	protected $urlForRequest;

	/**
	 * @var string Ключ для доступа к API
	 */
	protected $apiKey;

	/**
	 * @var string Сочетания языка и страны, для которых будут возвращены данные погодных формулировок
	 */
	protected $lang;

	/**
	 * Конструктор класса.
	 *
	 * @param string $apiKey Ключ для доступа к API
	 * @param string $lang Сочетания языка и страны, для которых будут возвращены данные погодных формулировок
	 */
	public function __construct(string $apiKey, string $lang = 'ru_RU')
	{
		$this->urlForRequest = 'https://api.weather.yandex.ru/v1/forecast';
		$this->apiKey = $apiKey;
		$this->lang = $lang;
	}

	public function getFactData(City $city): WeatherFactData
	{
		$httpClient = new \GuzzleHttp\Client();
		$response = $httpClient->request('GET', $this->urlForRequest, [
			'http_errors' => false,
			'headers' => [
				'X-Yandex-API-Key' => $this->apiKey,
			],
			'query' => [
				'lat' => $city->lat,
				'lon' => $city->lon,
				'lang' => $this->lang,
			],
		]);
		if ($response->getStatusCode() === 200) {
			$responseData = json_decode($response->getBody());

			$factData = new WeatherFactData();
			$factData->setTemp($responseData->fact->temp);

			return $factData;
		} else {
			throw new WeatherClientApiException('Can not get weather data: Invalid response code: ' . $response->getStatusCode());
		}
	}
}