<?php
/**
 * @author Ivan Matveev <Redjiks@gmail.com>.
 */

namespace WorldWeatherOnline;

use WorldWeatherOnline\Driver\Driver;
use WorldWeatherOnline\Translation\Translator;


class WeatherForecasts implements \Iterator
{
	protected $data = array();
	
	protected $translator;

	/**
	 * @param Driver $driver
	 * @param Translator $translator
	 * @throws Exception
	 */
	public function __construct(Driver $driver, Translator $translator)
	{
		$data = $driver->getWeatherData();

		$this->translator = $translator;
		
		if(empty($data) || !isset($data->data)){
			throw new Exception('Service returned no data');
		}

		$data = $data->data;

		if (!isset($data->weather)){
			throw new Exception('Data is corrupted - no weather array item');
		}

		if (empty($data->weather)){
			throw new Exception('Weather is empty 0_o');
		}

		$this->data = $data->weather;
	}

	/**
	 * @return string Local forecast date
	 */
	public function getDate()
	{
		$data = current($this->data);
		return $data->date;
	}

	/**
	 * @return string Precipitation in millimetres
	 */
	public function getPrecipMM()
	{
		$data = current($this->data);
		return $data->precipMM;
	}

	/**
	 * @return string Maximum temperature of the day in degree Celsius
	 */
	public function getTempMaxC()
	{
		$data = current($this->data);
		return $data->tempMaxC;
	}

	/**
	 * @return string Maximum temperature of the day in degree Fahrenheit
	 */
	public function getTempMaxF()
	{
		$data = current($this->data);
		return $data->tempMaxF;
	}

	/**
	 * @return string Minimum temperature of the day in degree Celsius
	 */
	public function getTempMinC()
	{
		$data = current($this->data);
		return $data->tempMinC;
	}

	/**
	 * @return string Minimum temperature of the day in degree Fahrenheit
	 */
	public function getTempMinF()
	{
		$data = current($this->data);
		return $data->tempMinF;
	}

	/**
	 * @return string Weather condition
	 */
	public function getWeatherString()
	{
		$data = current($this->data);
		return $this->translator->translateCode($data->weatherCode);
	}

	/**
	 * @return string @see WeatherForecasts::getWindDir16Points()
	 */
	public function getWindDirection()
	{
		$data = current($this->data);
		return $this->translator->translateWindDirection($data->winddirection);
	}

	/**
	 * @return string Wind direction in 16-point compass
	 */
	public function getWindDir16Points()
	{
		$data = current($this->data);
		return $this->translator->translateWindDirection($data->winddir16Point);
	}

	/**
	 * @return string Wind direction in degrees
	 */
	public function getWindDirDegree()
	{
		$data = current($this->data);
		return $data->winddirDegree;
	}

	/**
	 * @return string Wind speed in kilometres per hour
	 */
	public function getWindSpeedKmph()
	{
		$data = current($this->data);
		return $data->windspeedKmph;
	}

	/**
	 * @return string Wind speed in miles per hour
	 */
	public function getWindSpeedMiles()
	{
		$data = current($this->data);
		return $data->windspeedMiles;
	}

	public function getIconUrlFromWorldWeatherOnline()
	{
		$data = current($this->data);
		return $data->weatherIconUrl[0]->value;
	}

	public function getIcon()
	{
		$data = current($this->data);
		return $this->translator->getIconName($data->weatherCode);
	}


	public function renderPoweredBy($return = false)
	{
		$poweredBy = 'Powered by <a href="http://www.worldweatheronline.com/" title="Free local weather content provider" target="_blank">World Weather Online</a>';

		if ($return){
			return $poweredBy;
		}else{
			echo $poweredBy;
		}

		return true;
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Return the current element
	 * @link http://php.net/manual/en/iterator.current.php
	 * @return WeatherForecasts.
	 */
	public function current()
	{
		return $this;
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Move forward to next element
	 * @link http://php.net/manual/en/iterator.next.php
	 * @return void Any returned value is ignored.
	 */
	public function next()
	{
		next($this->data);
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Return the key of the current element
	 * @link http://php.net/manual/en/iterator.key.php
	 * @return mixed scalar on success, or null on failure.
	 */
	public function key()
	{
		return key($this->data);
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Checks if current position is valid
	 * @link http://php.net/manual/en/iterator.valid.php
	 * @return boolean The return value will be casted to boolean and then evaluated.
	 * Returns true on success or false on failure.
	 */
	public function valid()
	{
		return current($this->data);
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Rewind the Iterator to the first element
	 * @link http://php.net/manual/en/iterator.rewind.php
	 * @return void Any returned value is ignored.
	 */
	public function rewind()
	{
		reset($this->data);
	}
}