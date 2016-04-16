<?php

namespace TP3;

class Database
{
	private static $instance = NULL;

	public static function instance ()
	{
		if (static::$instance === NULL)
		{
			static::$instance = new \PDO('mysql:host=mysql;dbname=poirigui_tp3', getenv('DATABASE_USERNAME'), getenv('DATABASE_PASSWORD'));
		}
		return static::$instance;
	}

	public static function fetch($class, $query, $params) {
		$statement = static::instance()->prepare($query);
		$statement->execute($params);
		return $statement->fetchObject($class);
	}

	public static function fetchAll($class, $query, array $params = NULL)
	{
		$statement = static::instance()->prepare($query);
		$statement->execute($params);
		return $statement->fetchAll(\PDO::FETCH_CLASS, $class);
	}
}
