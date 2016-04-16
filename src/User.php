<?php

namespace TP3;

class User extends Model
{
	/**
	 * Récupère l'utilisateur actuellement connecté.
	 *
	 * Il est important que la session soit disponible avant d'appeler 
	 * cette fonction.
	 */
	public static function current() {
		return isset($_SESSION) && array_key_exists('user_id', $_SESSION) ? static::find_by_id($_SESSION['user_id']) : NULL;
	}

	/**
	 * Récupère un usager étant donné son pseudonyme.
	 */
	public static function find_by_username($username) {
		return \TP3\Database::fetch('\TP3\User', 'select * from users where username = ?', array($username));
	}

	/**
	 * Authentifie un usager et retourne le modèle correspondant en cas de 
	 * succès.
	 */
	public static function authenticate($username, $password) {
		$stmt = \TP3\Database::instance()
			->prepare('select * from users where username = ?');
		$stmt->execute(array($username));
		$user = $stmt->fetchObject('\TP3\User');
		return $user ? password_verify($password, $user->password_hash) ? $user : NULL : NULL;
	}

	/**
	 * Inscrit un usager.
	 */
	public static function register($username, $email, $password)
	{
		return \TP3\Database::instance()
			->prepare('insert into users (username, email, password_hash) values (?, ?, ?)')
			->execute(array($username,  $email, password_hash($password, PASSWORD_BCRYPT)));
	}

	/**
	 * Récupère tous les Wikis dont cet usager est l'auteur.
	 *
	 * Il peut s'agir de simples modifications.
	 */
	public function wikis() {
		return \TP3\Database::fetchAll('\TP3\Wiki', 
			'select * from wikis where author_id = ? order by created desc', 
			array($this->id));
	}
}
