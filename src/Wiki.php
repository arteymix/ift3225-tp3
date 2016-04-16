<?php

namespace TP3;

/**
 * Immutable object representing a Wiki document.
 */
class Wiki extends Model
{
	/**
	 * Récupère un Wiki correspondant à un WikiName. 
	 */
	public static function find_by_wiki_name ($wiki_name) {
		return \TP3\Database::fetch('\TP3\Wiki', 
			'select * from wikis where title = ? order by created desc', 
			array($wiki_name));
	}

	/**
	 * Récupère les Wikis correspondant aux termes d'une recherche.
	 */
	public static function all_by_terms($terms) {
		return \TP3\Database::fetchAll('\TP3\Wiki', 
			'select * from wikis where lower(title) LIKE ? or lower(document) LIKE ? group by title order by created desc', 
			array('%'.strtolower($terms).'%', '%'.strtolower($terms).'%'));
	}

	/**
	 * Récupère l'auteur d'un Wiki.
	 */
	public function author() {
		return \TP3\Database::fetch('\TP3\User', 'select * from users where id = ?', array($this->author_id));
	}

	/**
	 * Récupère le parent d'un Wiki, si il existe.
	 */
	public function parent() {
		return \TP3\Database::fetch('\TP3\Wiki', 'select * from wikis where id = ?', array($this->parent_id));
	}
}
