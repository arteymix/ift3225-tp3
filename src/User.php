<?php

namespace TP3;

class User
{
	public static function find($id) {

	}

	public static function authenticate($username, $password) {
		\Database::instance()
			->prepare('select from users where username = ?')
			->execute(array('username' => $username))
		    ->fetch();
	}

	public static function register($username, $email, $password)
	{
		\Database::instance()
			->prepare('insert into users (username, email, password_hash) values (?, ?, ?)')
			->execute(array(
				'username' => $username,
				'email'    => $email,
				'password' => password_hash($password, PASSWORD_BCRYPT)
			));

		return new \User($username, $email);
	}

	public function __construct($username, $email, $admin) {
		$this->username = $username;
		$this->email    = $email;
		$this->admin    = (bool) $admin;
	}
}
