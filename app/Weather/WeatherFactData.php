<?php
namespace App\Weather;

/**
 * Класс, содержащий данные о текущем состоянии погоды в городе.
 *
 * @package App\Weather
 */
class WeatherFactData
{
	/**
	 * @var int Температура воздуха
	 */
	protected $temp;

	/**
	 * Получает температуру воздуха.
	 *
	 * @return int|null
	 */
	public function getTemp()
	{
		return $this->temp;
	}

	/**
	 * Устанавливает температуру воздуха.
	 *
	 * @param int $value
	 */
	public function setTemp(int $value)
	{
		$this->temp = $value;
	}
}