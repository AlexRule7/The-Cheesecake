<?php
	
	class Database {
		private static $_connection;
		private static $host = 'localhost';
		private static $username = 'denjer_ck';
		private static $passwd = 'thecheesecake13';
		private static $dbname = 'denjer_ck';	
		
		public static function connect() {
			$mysqli = new mysqli(self::$host, self::$username, self::$passwd, self::$dbname);
			if ($mysqli->connect_errno) {
				echo 'Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
				exit;
			} else {
				$mysqli->set_charset('utf8');
				self::$_connection = $mysqli;
			}
		}
		
		public static function getConnection() {
			return self::$_connection;
		}
		
		public static function sanitize($data) {
			$_data = trim($data); 
			if(get_magic_quotes_gpc()) {
				$_data = stripslashes($_data); 
			}
			$_data = self::$_connection->real_escape_string($_data);
			
			return $_data;
		}
	}
	
	Database::connect();
	$mysqli = Database::getConnection();
	
	include($_SERVER['DOCUMENT_ROOT'].'/include/user.functions.php');
	
?>