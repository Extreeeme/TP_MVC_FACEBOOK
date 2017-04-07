<?php 
	
	use Core\Auth\DBAuth;
	define('ROOT', dirname(__DIR__));
	require ROOT.'/vendor/app/App.php'; // permet l'absolute
	App::load();

	if (isset($_GET['p'])) {
		$page = $_GET['p'];
	}else{
		$page = "home";
	}

	//////////////bouton connect 
	$app = App::getInstance();
	$auth = new DBAuth($app->getDb());
	if ($auth->logged()) {
		$connect = "Disconnect";
	}else{
		$connect = "login";
	}
	/////////////////////////

	ob_start();
	if ($page==='home') {  // Charge centre page ($content)
		require ROOT.'/vendor/pages/index.php';
	}elseif ($page==='login') {
		require ROOT.'/vendor/pages/users/login.php';
	}elseif ($page==='Disconnect') {
		require ROOT.'/vendor/pages/users/disconnect.php';
	}elseif ($page==='register') {
		require ROOT.'/vendor/pages/users/register.php';
	}elseif ($page==='login-callback') {
		require ROOT.'/vendor/pages/users/login-callback.php';
	}elseif ($page==='register-callback') {
		require ROOT.'/vendor/pages/users/register-callback.php';
	}elseif ($page==='loginFacebook') {
		require ROOT.'/vendor/pages/users/loginFacebook.php';
	}elseif ($page==='registerFacebook') {
		require ROOT.'/vendor/pages/users/registerFacebook.php';
	}elseif ($page==='remember') {
		require ROOT.'/vendor/pages/users/remember.php';
	}elseif ($page==='reset') {
		require ROOT.'/vendor/pages/users/reset.php';
	}elseif ($page==='confirm') {
		require ROOT.'/vendor/pages/users/confirm.php';
	}elseif ($page==='registerFacebook') {
		require ROOT.'/vendor/pages/users/registerFacebook.php';
	}elseif ($page==='403') {
		require ROOT.'/vendor/pages/errors/403.php';
	}elseif ($page==='404') {
		require ROOT.'/vendor/pages/errors/404.php';
	}
	$content = ob_get_clean(); // Le template 
	require ROOT.'/vendor/pages/templates/default.php'; 
?>