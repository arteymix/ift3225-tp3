<?php

namespace TP3;

class Database
{
	private static $instance = NULL;

	public static function instance ()
	{
		if (static::$instance === NULL)
		{
			static::$instance = new \PDO('mysql:/localhost');
		}
		return static::$instance;
	}
}
