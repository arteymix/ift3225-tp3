<?php

namespace TP3;

/**
 * Provide {@link \Wiki} document from a database.
 */
class DatabaseWikiProvider extends WikiProvider
{
	public function __construct(\PDO $pdo) {
		$this->database = $pdo;
	}

	public function find_by_wiki_name ($wiki_name){
		//do stuff
	}

}

