<?php

namespace TP3;

class Database
{
	private static $instance = NULL;

	public static function instance ()
	{
		if (static::$instance === NULL)
		{
			static::$instance = new \PDO('mysql:host=localhost;dbname=tp3', 'tp3', 'tp3');
		}
		return static::$instance;
	}
}
