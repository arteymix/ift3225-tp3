<?php

namespace \TP3;

class \User
{
	public static function find($id) {

	}

	public static function authenticate($username, $password) {
		\Database::instance()
			->prepare('select from users where username = ?')
			->execute(array('username' => $username))
		    ->fetch();

		if ($result)
		$database
	}

	public static function register($username, $email, $password)
	{
		\Database::instance()
			->prepare('insert into users (username, email, password_hash) values (?, ?, ?)')
			->execute(
				'username' => $username,
				'email'    => $email,
				'password' => password_hash($password, PASSWORD_BCRYPT)
			);

		return new \User($username, $email);
	}

	public __construct($username, $email, bool $admin) {
		$this->username = $username;
		$this->email    = $email;
		$this->admin    = $admin;
	}
}
