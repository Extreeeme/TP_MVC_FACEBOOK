<?php
if(!session_id()) {
    session_start();
}
use Core\Auth\DBAuth;
$app2 = App::getInstance();
$auth2 = new DBAuth($app2->getDb());

if ($auth2->logged()) {
	header('location: admin.php');
}

$fb = new Facebook\Facebook([
  'app_id' => '421674024852694',
  'app_secret' => '2388666436ccf5ba7e9e2c4407dacfac',
  'default_graph_version' => 'v2.8',
]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email', 'user_friends'];// Optional permissions
$loginUrl = $helper->getLoginUrl('http://tpfinal.loc/index.php?p=login-callback', $permissions);

?>
<div class="col-md-6 col-md-offset-3">
<h2>CONNEXION</h2>
</div>

<div class="col-md-6 col-md-offset-3">
	<form method="Post" action="admin.php">
		<input class="form-control" type="text" name="username" placeholder="nom d'utilisateur">
		<input class="form-control" type="password" name="password" placeholder="mot de passe">
		<input class="btn btn-primary" type="submit">
	</form>
	<?php echo '<a href="' . $loginUrl . '">Connexion avec Facebook !</a>';?>
</div>

