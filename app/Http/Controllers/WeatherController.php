<?php
namespace App\Http\Controllers;

use App\City;
use App\Exceptions\WeatherClientApiException;
use App\Weather\YandexWeatherApiClient;

class WeatherController extends Controller
{
	/**
	 * Отображает страницу с информацией о погоде.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		$cityName = 'Брянск';
		$city = City::where('name', '=', $cityName)->firstOrFail();

		try {
			$weatherApiClient = new YandexWeatherApiClient(config('yandex.api_key'));
			$factData = $weatherApiClient->getFactData($city);
		} catch (WeatherClientApiException $ex) {
			$factData = null;
		}

		return view('weather', [
			'cityName' => $cityName,
			'factData' => $factData,
		]);
	}
}