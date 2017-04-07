<?php
namespace App\Table;

use Core\Table\Table;

/**
* Classe User
*/
class UserTable extends Table
{
	public function findUser($email)
	{
		$user = $this->query("SELECT * FROM users WHERE email = ?", [$email], true);
		return $user->id;
	}

	public function findUserToken($id, $token)
	{
		$user = $this->query("SELECT * FROM users WHERE id = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > NOW()-(1000*60*30)", [$id, $token], true);
		return $user;
	}
// $req = $pdo->prepare('SELECT * FROM users WHERE id = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > NOW()-(1000*60*30)');
	public function findUserRemember($email)
	{
		$user = $this->query("SELECT * FROM users WHERE email = ? AND valid_at IS NOT NULL", [$email], true);
		return $user;
	}

	public function updateToken($id)
	{
		return $this->query("UPDATE users SET valid_token = NULL, valid_at = NOW() WHERE id = ?", [$id]);
	}

	public function updateTokenRemember($id, $token)
	{
		return $this->query("UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id = ?", [$token, $id]);
	}

	public function updatePassword($id, $password)
	{
		return $this->query("UPDATE users SET password = ?, reset_token = NULL, reset_at = null WHERE id =?", [$password, $id]);
	}
}
