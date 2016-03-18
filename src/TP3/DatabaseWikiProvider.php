<?php

namespace \TP3;

/**
 * Provide {@link \Wiki} document from a database.
 */
public class \DatabaseWikiProvider extends \WikiProvider
{
	public \DatabaseWikiProvider(\PDO $pdo) {
		$this->database = $pdo;
	}

	public function find_by_wiki_name ($wiki_name) {
		$this->pdo->query('select * from wikis where name = ?')
		return new \Wiki ();
	}
}

