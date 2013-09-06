<?php
/**
 * @author Ivan Matveev <Redjiks@gmail.com>.
 */

namespace WorldWeatherOnline\Driver;


class PhpDriver extends Driver
{

	public function getWeatherDataInner()
	{
		return file_get_contents($this->getQueryString());
	}
}