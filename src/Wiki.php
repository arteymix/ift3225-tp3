<?php

namespace TP3;

/**
 * Immutable object representing a Wiki document.
 */
class Wiki
{
	public static function find_by_wiki_name ($wiki_name) {
		$stmt = \TP3\Database::instance()
			->prepare('select * from wikis where title = ?');
		$stmt->execute(array($wiki_name));
		return $stmt->fetchObject('\TP3\Wiki');
	}
}
