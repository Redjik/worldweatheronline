<?php
/**
 * @author Ivan Matveev <Redjiks@gmail.com>.
 */

namespace WorldWeatherOnline\Translation;


class Translator
{
	public static $lang;

	/**
	 * @param $lang
	 * @throws Exception
	 */
	public static function setLanguage($lang)
	{
		$file = __DIR__.'/'.$lang.'.php';
		if (is_readable($file)){
			static::$lang = include_once($file);
		}else{
			throw new Exception('File with translation can not be read');
		}
	}

	/**
	 * @param $code
	 * @return mixed
	 * @throws Exception
	 */
	public static function translateCode($code)
	{
		static::setDefaultLanguage();

		if (!isset(static::$lang['codes'][(int)$code])){
			throw new Exception('No translation for current weather code - '.$code);
		}

		return static::$lang['codes'][(int)$code];
	}

	/**
	 * @param $direction
	 * @return mixed
	 * @throws Exception
	 */
	public static function translateWindDirection($direction)
	{
		static::setDefaultLanguage();

		if (!isset(static::$lang['wd'][$direction])){
			throw new Exception('No translation for current wind direction - '.$direction);
		}

		return static::$lang['wd'][$direction];
	}


	/**
	 * @param $code
	 * @return mixed
	 * @throws Exception
	 */
	public static function getIconName($code)
	{
		static::setDefaultLanguage();

		if (!isset(static::$lang['icons'][(int)$code])){
			throw new Exception('No icon for current weather code - '.$code);
		}

		return static::$lang['icons'][(int)$code];
	}

	/**
	 * Sets default lang as english
	 */
	protected static function setDefaultLanguage()
	{
		if (static::$lang === null)
			static::setLanguage('en');
	}

}