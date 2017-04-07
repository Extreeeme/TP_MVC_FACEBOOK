<?php
use Core\Auth\DBAuth;
$app2 = App::getInstance();
$auth2 = new DBAuth($app2->getDb());

if ($auth2->logged()) {
	header('location: admin.php');
}else{
	if(isset($_GET['id']) && isset($_GET['token'])){
		$user = App::getInstance()->getTable('User')->findUserToken($_GET['id'], $_GET["token"]);
		if (!empty($_POST)) {
			if (!empty($_POST['password']) && $_POST['password'] == $_POST['password2']) {
				$user_id = $user->id;
				$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
				App::getInstance()->getTable('User')->updatePassword($user_id, $password);
				header('location: index.php?p=login');
				exit();
			}
		}
	}
}

?>

<div class="col-md-6 col-md-offset-3">
<h2>RECUPERATION DE MOT DE PASSE</h2>
</div>

<div class="col-md-6 col-md-offset-3">
	<form method="POST" action="">
		<input class="form-control" type="password" name="password" placeholder="Nouveau mot de passe">
		<input class="form-control" type="password" name="password2" placeholder="Nouveau mot de passe">
		<input class="btn btn-primary" type="submit">
	</form>
</div>