<?php
//TEST
/**
 * Fuel is a fast, lightweight, community driven PHP 5.4+ framework.
 *
 * @package    Fuel
 * @version    1.8.1
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2018 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * Session Class
 *
 * @package		Fuel
 * @category	Core
 * @author		Harro "WanWizard" Verton
 * @link		http://docs.fuelphp.com/classes/session.html
 */
class SessionTest extends Session
{
	/**
	 * get session key variables
	 *
	 * @param	string	$name	name of the variable to get, default is 'session_id'
	 * @return	mixed
	 */
	public static function key($name = 'session_id')
	{
//		return static::$_instance ? static::instance()->key($name) : null;
		return static::$_instance ? session_id() : null;
	}
}
