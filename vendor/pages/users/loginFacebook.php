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
?>
<div class="col-md-6 col-md-offset-3">
<h2>CONNEXION</h2>
</div>

<div class="col-md-6">
	<form method="Post" action="admin.php">
		<input class="form-control" type="text" name="username" placeholder="nom d'utilisateur">
		<input class="form-control" type="password" name="password" placeholder="mot de passe">
		<input class="btn btn-primary" type="submit">
	</form>
</div>

<?php echo '<a href="' . $loginUrl . '">Connexion avec Facebook!</a>';?>