<?php
/**
 * @author Ivan Matveev <Redjiks@gmail.com>.
 */

include_once(__DIR__.'/autoloader.php');

$loader = new Symfony\Component\ClassLoader\UniversalClassLoader();
$loader->registerNamespace('WorldWeatherOnline',__DIR__);
$loader->register();

use WorldWeatherOnline\Translation\Translator;
use WorldWeatherOnline\WeatherForecasts;
use WorldWeatherOnline\Driver\Driver;

$apiKey = 'Your Api Key';
$driver = Driver::factory($apiKey);
$driver->setCity('London');

$translator = new Translator();
$worldWeather = new WeatherForecasts($driver,$translator);

/** @var $worldWeather WeatherForecasts[] */
foreach ($worldWeather as $weather)
{
	echo 'from '.$weather->getTempMinC().' to '.$weather->getTempMaxC().' '.$weather->getWeatherString().' will be at '.$weather->getDate().
		 ' <img src="'.$weather->getIconUrlFromWorldWeatherOnline().'" />'."<br>";
}
