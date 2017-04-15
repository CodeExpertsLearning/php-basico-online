<?php 

function login($data, $pdo)
{
	$sql = "SELECT email, password FROM users WHERE email = :email AND password = :password";

	$login = $pdo->prepare($sql);

	$login->bindValue(':email', $data['email'], PDO::PARAM_STR);
	$login->bindValue(':password', sha1($data['password'] . APP_KEY), PDO::PARAM_STR);

	$login->execute();

	return $login->fetch(PDO::FETCH_ASSOC);
}