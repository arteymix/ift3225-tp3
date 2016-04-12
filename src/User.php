<?php

namespace TP3;

class User
{
	public static function all() {
		$stmt = \TP3\Database::instance()
			->prepare('select * from users');
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_CLASS, '\TP3\User');
	}

	public static function current() {
		return isset($_SESSION) && array_key_exists('user_id', $_SESSION) ? static::find_by_id($_SESSION['user_id']) : NULL;
	}

	public static function find_by_id($id) {
		$stmt = \TP3\Database::instance()
			->prepare('select * from users where id = ?');
		$stmt->execute(array($id));
		return $stmt->fetchObject('\TP3\User');
	}

	public static function find_by_username($username) {
		$stmt = \TP3\Database::instance()
			->prepare('select * from users where username = ?');
		$stmt->execute(array($username));
		return $stmt->fetchObject('\TP3\User');
	}

	public static function authenticate($username, $password) {
		$stmt = \TP3\Database::instance()
			->prepare('select * from users where username = ?');
		$stmt->execute(array($username));
		$user = $stmt->fetchObject('\TP3\User');
		return $user ? password_verify($password, $user->password_hash) ? $user : NULL : NULL;
	}

	public static function register($username, $email, $password)
	{
		return \TP3\Database::instance()
			->prepare('insert into users (username, email, password_hash) values (?, ?, ?)')
			->execute(array($username,  $email, password_hash($password, PASSWORD_BCRYPT)));
	}

	public function wikis() {
		$stmt = \TP3\Database::instance()
			->prepare('select * from wikis where author_id = ? order by created desc');
		$stmt->execute(array($this->id));
		return $stmt->fetchAll(\PDO::FETCH_CLASS, '\TP3\Wiki');
	}
}
