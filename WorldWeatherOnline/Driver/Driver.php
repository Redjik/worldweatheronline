<?php
/**
 * @author Ivan Matveev <Redjiks@gmail.com>.
 */

namespace WorldWeatherOnline\Driver;


abstract class Driver
{
	const API_URL = 'http://api.worldweatheronline.com';

	const PREMIUM_POSTFIX = 'premium';

	const FREE_POSTFIX = 'free';

	const API_URL_SUFFIX = 'v1/weather.ashx';

	const FORMAT = 'json';

	protected static $data;

	protected $apiKey;

	protected $premiumAccess = false;

	protected $city = null;

	protected $numberOfDays = 5;

	/**
	 * set api to premium access
	 */
	public function setPremiumAccess()
	{
		$this->premiumAccess = true;
	}

	/**
	 * set api to free access
	 */
	public function setFreeAccess()
	{
		$this->premiumAccess = false;
	}

	/**
	 * @param int $numberOfDays Number of days of forecast
	 */
	public function setNumberOfDays($numberOfDays)
	{
		$this->numberOfDays = $numberOfDays;
	}

	/**
	 * @param mixed $city  IP address, Latitude/Longitude (decimal degree) or city name
	 */
	public function setCity($city)
	{
		$this->city = $city;
	}

	/**
	 * @param null $apiKey the api key
	 * @throws Exception
	 */
	public function __construct($apiKey = null)
	{
		$this->apiKey = $apiKey;

		static::$data = null;

		if ($apiKey === null){
			throw new Exception('You should specify api key');
		}
	}

	/**
	 * @param null|string $apiKey Your WorldWeatherOnline api key
	 * @param string $type type of connection driver
	 * @return Driver
	 */
	public static function factory($apiKey = null, $type = 'php')
	{
		/** @var $className Driver */
		$className = __NAMESPACE__ . '\\' .ucfirst($type).'Driver';
		return new $className($apiKey);
	}

	/**
	 * Query string for REST api call
	 * @return string
	 */
	protected function getQueryString()
	{
		$data = http_build_query(array(
			'format'=>self::FORMAT,
			'q'=>$this->getCity(),
			'key'=>$this->apiKey,
			'num_of_days'=>$this->numberOfDays,
			'cc'=>'no'
		));
		return self::API_URL.'/'.($this->premiumAccess?self::PREMIUM_POSTFIX:self::FREE_POSTFIX).'/'.self::API_URL_SUFFIX.'?'.$data;
	}

	/**
	 * Make REST api call
	 * @return mixed
	 */
	final public function getWeatherData()
	{
		set_error_handler(function($errno, $errstr, $errfile, $errline){
			throw new Exception('Could not resolve connection: '.$errstr);
		},E_ALL);

		if (static::$data === null){
			static::$data = $this->getWeatherDataInner();
		}
		restore_error_handler();

		return json_decode(static::$data);
	}

	/**
	 * Driver realisation of api call
	 * @return mixed
	 */
	abstract protected function getWeatherDataInner();


	/**
	 * @return null
	 */
	protected function getCity()
	{
		if ($this->city === null){
			return $_SERVER['REMOTE_ADDR'];
		}
		return $this->city;
	}
}