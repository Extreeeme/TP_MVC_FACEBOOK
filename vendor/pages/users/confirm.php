<?php

use Core\Auth\DBAuth;
$app2 = App::getInstance();
$auth2 = new DBAuth($app2->getDb());

	if(isset($_GET["id"]) && isset($_GET["token"])){
	$user_id = $_GET['id'];
	$user_token = $_GET["token"];
	$user = App::getInstance()->getTable('User')->find($user_id);
	if($user && $user->valid_token == $user_token){
		App::getInstance()->getTable('User')->updateToken($user->id);
		header('location: index.php?p=login');
		exit();
	}
	}
		header('location: index.php');
