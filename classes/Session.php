<?php
class Session {
	public static function start() {
		if (!isset($_SESSION)) {
			session_start();
		}
	}

	public static function stop() {
		self::start();
		foreach ($_SESSION as $k=>$v) {
			unset($_SESSION[$k]);
		}
		session_destroy();
	}

	public static function get($key, $default = null) {
		self::start();
		if (isset($_SESSION[$key])) return $_SESSION[$key];
		else return $default;
	}

	public static function set($key, $value) {
		self::start();
		$_SESSION[$key] = $value;
	}

	// na strani na kojoj zabranjujemo: 

	/*
	if (!Session::get('status') || Session::get('status')!=3);
	header("location: index.php"); */
} 