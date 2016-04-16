<?php

namespace TP3;

/**
 * Modèle représentant une entité de la base de données.
 */
abstract class Model
{
	/**
	 * Détermine le nom de la table qui stocke le modèle.
	 */
	public static function table_name() {
		return strtolower(end(explode('\\', get_called_class()))).'s';
	}

	/**
	 * Récupère tous les modèles.
	 */
	public static function all() {
		return \TP3\Database::fetchAll(get_called_class(), 'select * from '.static::table_name());
	}

	/**
	 * Récupère un modèle selon son identifiant.
	 */
	public static function find_by_id($id) {
		return \TP3\Database::fetch(get_called_class(), 'select * from '.static::table_name().' where id = ?', array($id));
	}
}
