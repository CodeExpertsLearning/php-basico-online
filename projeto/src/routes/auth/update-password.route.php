<?php

function getTokenInfo($token, $pdo)
{
	$sql = 'SELECT * FROM remember_password WHERE remember_token = :token';

	$getToken = $pdo->prepare($sql);

	$getToken->bindValue(':token', $token, PDO::PARAM_STR);

	$getToken->execute();

	return $getToken->fetch(PDO::FETCH_ASSOC);
}

$token =  isset($page[2])? $page[2] : null;


if($_SERVER['REQUEST_METHOD'] == 'POST') {

	$data = $_POST;

	if($data['password'] != $data['confirm_password']) {
		addFlash('error', 'Senhas não conferem!');
		return header('Location: ' . HOME . '/auth/atualizar-senha/' . $token);
	}

	require APP_ROOT . '/src/functions/admin/users.php';

	sessionStart();

	$data['id'] = $_SESSION['user_remember_password'];
	$data['password'] = $data['password'];

	if(!update(connection(), $data)) {
		addFlash('error', 'Erro ao atualizar senha!');
		return header('Location: ' . HOME . '/auth/atualizar-senha/' . $token);
	}

	unset($_SESSSION['user_remember_password']);
	session_destroy();

	addFlash('success', 'Senha atualizada com sucesso, faça login para acessar o painel!');
	return header('Location: ' . HOME . '/auth/login');

}

if(is_null($token)) {
	addFlash('error', 'Token não informado!');
	return header('Location: ' . HOME . '/auth/login');
}

$getTokenInfo = getTokenInfo($token, connection());

if(!$getTokenInfo) {
	addFlash('error', 'Token não encontrado!');
	return header('Location: ' . HOME . '/auth/relembrar-senha');
}

if(date('Ymd') > date('Ymd', strtotime($getTokenInfo['expires']))) {
	addFlash('error', 'Token expirado!');
	return header('Location: ' . HOME . '/auth/relembrar-senha');
}

sessionStart();

$_SESSION['user_remember_password'] = $getTokenInfo['user_id'];

require VIEWS . '/' . $page[0] . '/password.phtml';
