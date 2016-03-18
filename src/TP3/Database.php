<?php

namespace \TP3;

class \Database
{
	private static \PDO $instance = NULL;

	public \PDO instance ()
	{
		if ($instance === NULL)
		{
			$instance = new \PDO('mysql://localhost');
		}
		return $instance;
	}
}
