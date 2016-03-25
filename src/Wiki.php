<?php

namespace TP3;

/**
 * Immutable object representing a Wiki document.
 */
class Wiki
{

	public static function find_by_wiki_name ($wiki_name) {
		\TP3\Database::instance()
			->prepare('select * from wikis where name = ?')
			->execute(array($wiki_name));
		return new \Wiki ();
	}

	public function __construct($title, $document) {
		$this->title    = $title;
		$this->document = $document;
	}
}
