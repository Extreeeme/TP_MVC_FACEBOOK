<?php
use Core\Auth\DBAuth;
$app2 = App::getInstance();
$auth2 = new DBAuth($app2->getDb());

if ($auth2->logged()) {
	header('location: admin.php');
}else{
	if ($_POST) {
		if (isset($_POST["email"])) {
			if (!$auth->register($_POST['email'])) {
				require_once ROOT.'/vendor/app/function.php';
				$user = App::getInstance()->getTable("User")->findUserRemember($_POST["email"]);
				if (!empty($user)) {
					$reset_token = str_random(60);
					App::getInstance()->getTable("User")->updateTokenRemember($user->id, $reset_token);
					my_mail(
						$_POST['email'],
						$user->name,
						'réinitialisez votre mot de passe',
						"Merci de cliquer sur le lien pour réinitialiser votre mot de passe <br/>\n\n http://tpfinal.loc/index.php?p=reset&id=$user->id&token=$reset_token"
						);
				}
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
		<input class="form-control" type="email" name="email" placeholder="Email">
		<input class="btn btn-primary" type="submit">
	</form>
</div>