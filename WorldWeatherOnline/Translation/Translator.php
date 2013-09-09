<?php
/**
 * @author Ivan Matveev <Redjiks@gmail.com>.
 */

namespace WorldWeatherOnline\Translation;


class Translator
{
	public $lang;

	/**
	 * @param string $lang name of the file in files folder (.php extension excuded)
	 */
	public function __construct($lang = 'en')
	{
		$this->setLanguage($lang);
	}

	/**
	 * @param string $lang
	 * @throws Exception
	 */
	protected function setLanguage($lang)
	{
		$file = __DIR__.'/files/'.$lang.'.php';
		if (is_readable($file)){
			$this->lang = include_once($file);
		}else{
			throw new Exception('File with translation can not be read');
		}
	}

	/**
	 * @param $code
	 * @return mixed
	 * @throws Exception
	 */
	public function translateCode($code)
	{

		if (!isset($this->lang['codes'][(int)$code])){
			throw new Exception('No translation for current weather code - '.$code);
		}

		return $this->lang['codes'][(int)$code];
	}

	/**
	 * @param $direction
	 * @return mixed
	 * @throws Exception
	 */
	public function translateWindDirection($direction)
	{

		if (!isset($this->lang['wd'][$direction])){
			throw new Exception('No translation for current wind direction - '.$direction);
		}

		return $this->lang['wd'][$direction];
	}


	/**
	 * @param $code
	 * @return mixed
	 * @throws Exception
	 */
	public function getIconName($code)
	{

		if (!isset($this->lang['icons'][(int)$code])){
			throw new Exception('No icon for current weather code - '.$code);
		}

		return $this->lang['icons'][(int)$code];
	}

}