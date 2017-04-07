<?php

use Core\Database\MysqlDatabase;
use Core\Config;

class App
{
	public $titre = 'TP FINAL';
	
	private static $_instance;
	private $db_instance;

	public static function load() // donne l'accès à toutes les classes
	{
		if(!session_id()) {
		    session_start();
		}
		require_once __DIR__ . "/../../vendor/autoload.php";
		// require __DIR__.'/../app/Autoloader.php';
		// App\Autoloader::register();
		// require __DIR__.'/../core/Autoloader.php';
		// Core\Autoloader::register();
	}

	public static function getInstance(){
		if (is_null(self::$_instance)){ //garder toujours une même instance
			self::$_instance = new App();
		}
		return self::$_instance;
	}
	
	public function getTable($name){
		$class_name = '\\App\\Table\\'.ucfirst($name).'Table';
		return new $class_name($this->getDb());
	}

	public function getDb(){
		$config = Config::getInstance(__DIR__.'/../config/config.php');
		if (is_null($this->db_instance)){
				$this->db_instance = new MysqlDatabase(
					$config->get('db_name'),
					$config->get('db_user'),
					$config->get('db_pass'),
					$config->get('db_host'));
		}
		return $this->db_instance;
	}

	public function notFound()
	{
		header("HTML/1.0 404 Not Found");
		header('location: index.php?p=404');
	}	

	public function forbidden()
	{
		header("HTML/1.0 403 Forbidden");
		header('location: index.php?p=403');
	}

	
}