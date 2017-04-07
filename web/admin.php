<?php
if(!session_id()) {
    session_start();
}
use Core\Auth\DBAuth;

define('ROOT', dirname(__DIR__));
require ROOT.'/vendor/app/App.php'; // permet l'absolute
App::load();

if (isset($_GET['p'])) {
	$page = $_GET['p'];
}else{
	$page = "home";
}

if (isset($_SESSION['fb_access_token'])) {
	$fb = new Facebook\Facebook([
	 'app_id' => '421674024852694',
	 'app_secret' => '2388666436ccf5ba7e9e2c4407dacfac',
	 'default_graph_version' => 'v2.8',
	]);

	$fb->setDefaultAccessToken($_SESSION['fb_access_token']);

	try {
		$response = $fb->get('/me?fields=id,name,email,age_range,gender, locale, first_name, last_name');
		$userNode = $response->getGraphUser();
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		 // When Graph returns an error
		 echo 'Graph returned an error: ' . $e->getMessage();
		exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		// When validation fails or other local issues
		 echo 'Facebook SDK returned an error: ' . $e->getMessage();
		  exit;
	}
	$app = App::getInstance();
	$auth = new DBAuth($app->getDb());
}



if(isset($userNode)){
	if($auth->register($userNode->getField('email') === false)){
		$user_id = App::getInstance()->getTable("User")->find($userNode->getField('email'));
		$_SESSION['Auth'] = $user_id;
	}
}elseif ($_POST) {
	//connexion utilisateur via login.php
	if (isset($_POST['username'], $_POST['password'])) {
		if ($auth->login($_POST['username'], $_POST['password'])) {
			//prevoir un message flash
		}else{
			header('location: index.php?p=login');
			exit();
		}
	}
}


//fin connexion utilisateur via login.php
if(isset($auth)){
	if (!$auth->logged()) {
		$app->forbidden();
	}
}else{
	header('location:index.php?p=404');
}

$connect = "Disconnect";

ob_start();
if ($page==='home') {
	require ROOT.'/vendor/pages/admin/index.php';
	/////suite pour post
}else{
	require ROOT.'/vendor/pages/errors/404.php';
}
$content = ob_get_clean();
require ROOT.'/vendor/pages/templates/default.php'; 