<?php
if(!session_id()) {
    session_start();
}
use Core\Auth\DBAuth;
$app2 = App::getInstance();
$auth2 = new DBAuth($app2->getDb());

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

if ($auth2->logged()) {
	header('location: admin.php');
}else{
	if ($_POST) {
		if (isset($_POST['name'], $_POST['password'], $_POST["email"])) {
			if ($auth->register($_POST['email'])) {
				$password = password_hash($_POST["password"], PASSWORD_BCRYPT);
				App::getInstance()->getTable('User')->create([
					"name" => $_POST["name"],
					"password" => $password,
					"email" => $_POST["email"]
					]);
				$user = App::getInstance()->getTable("User")->findUserRemember($_POST["email"]);
				App::getInstance()->getTable('User')->updateToken($user->id);
				header('location: index.php?p=login');
			}else{
				
			}
		}
	}else{
		
	}
}

?>
<div class="col-md-6 col-md-offset-3">
<h2>INSCRIPTION</h2>
</div>
<div class="col-md-6 col-md-offset-3">
	<form method="POST" action="">
		<input class="form-control" type="text" name="name" value="<?=$userNode->getField("first_name")?>"placeholder="Pseudo">
		<input class="form-control" type="password" name="password" placeholder="Mot de passe">
		<input class="form-control" type="email" name="email" value="<?=$userNode->getField('email')?>"placeholder="Email">
		<input class="btn btn-primary" type="submit">
	</form>
</div>
