<?php

namespace TP3;

/**
 * Immutable object representing a Wiki document.
 */
class Wiki
{
	public static function find_by_wiki_name ($wiki_name) {
		$stmt = \TP3\Database::instance()
			->prepare('select * from wikis where title = ? order by created desc');
		$stmt->execute(array($wiki_name));
		return $stmt->fetchObject('\TP3\Wiki');
	}

	public static function all_by_terms($terms) {
		$stmt = \TP3\Database::instance()
			->prepare('select * from wikis where lower(document) LIKE ? order by created desc');
		$stmt->execute(array('%'.strtolower($terms).'%'));
		return $stmt->fetchAll(\PDO::FETCH_CLASS, '\TP3\Wiki');
	}
}
