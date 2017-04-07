<?php
if(!session_id()) {
    session_start();
}

use Core\Auth\DBAuth;
$app2 = App::getInstance();
$auth2 = new DBAuth($app2->getDb());

if ($auth2->logged()) {
	header('location: admin.php');
}else{
	if ($_POST) {
		if (isset($_POST['name'], $_POST['password'], $_POST["email"])) {
			if ($auth->register($_POST['email'])) {
				require_once ROOT.'/vendor/app/function.php';
				$token = str_random(60);
				$password = password_hash($_POST["password"], PASSWORD_BCRYPT);
				App::getInstance()->getTable('User')->create([
					"name" => $_POST["name"],
					"password" => $password,
					"email" => $_POST["email"],
					"valid_token" => $token
					]);
				$user_id = App::getInstance()->getTable("User")->findUser($_POST["email"]);
				my_mail(
					$_POST["email"],
					$_POST["name"],
					'confirmation de votre compte',
					 "Merci de cliquer sur le lien pour confirmer votre compte <br/>\n\n http://tpfinal.loc/index.php?p=confirm&id=$user_id&token=$token"
					  );
			}else{
				
			}
		}
	}
}

$fb = new Facebook\Facebook([
  'app_id' => '421674024852694',
  'app_secret' => '2388666436ccf5ba7e9e2c4407dacfac',
  'default_graph_version' => 'v2.8',
]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email', 'user_friends'];// Optional permissions
$loginUrl = $helper->getLoginUrl('http://tpfinal.loc/index.php?p=register-callback', $permissions);

?>
<div class="col-md-6 col-md-offset-3">
<h2>INSCRIPTION</h2>
</div>

<div class="col-md-6 col-md-offset-3">
	<form method="POST" action="">
		<input class="form-control" type="text" name="name" placeholder="Pseudo">
		<input class="form-control" type="password" name="password" placeholder="Mot de passe">
		<input class="form-control" type="email" name="email" placeholder="Email">
		<input class="btn btn-primary" type="submit">
	</form>

<?php echo '<a href="' . $loginUrl . '">Inscription avec Facebook !</a>';?>

</div>