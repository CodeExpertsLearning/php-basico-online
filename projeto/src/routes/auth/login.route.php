<?php

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = $_POST;

	$user = login($data, connection());

	if(!$user) {
		
		addFlash('error', 'Usuário ou senha incorretos!');

		return header('Location: ' . HOME . '/auth/login');

	} else {
		sessionStart();

		$_SESSION['user'] = $user;

		header('Location: ' .HOME . '/admin/dashboard');

	}
}

if(isset($_SESSION['user']))
	header('Location: ' .HOME . '/admin/dashboard');


require VIEWS . '/' . $page[0] . '/login.phtml';
