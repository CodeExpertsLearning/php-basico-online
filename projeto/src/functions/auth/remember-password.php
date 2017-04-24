<?php

function setNewToken($email, $pdo)
{
	$sql = "SELECT * FROM users WHERE email = :email";

	$select = $pdo->prepare($sql);

	$select->bindValue(':email', $email, PDO::PARAM_STR);

	$select->execute();

	if(!$select->rowCount())
		return false;

	$user = $select->fetch(PDO::FETCH_ASSOC);

	$token = uniqid() . sha1($email);

	$expires = date("Y-m-d", strtotime("+1 day"));

	$insert = "INSERT INTO 
					remember_password (user_id, remember_token, expires)
			   VALUE(:user_id, :remember_token, :expires)";

	$insert = $pdo->prepare($insert);

	$insert->bindValue(':user_id', $user['id'], PDO::PARAM_INT);
	$insert->bindValue(':remember_token', $token, PDO::PARAM_STR);
	$insert->bindValue(':expires', $expires, PDO::PARAM_STR);

	require APP_ROOT . '/src/functions/sendEmail.php';

	$data['name'] = $user['name'];
	$data['email'] = $email;
	$data['token'] = $token;

	sendEmail($data);


	return $insert->execute();
}