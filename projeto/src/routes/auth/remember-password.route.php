<?php

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $email = $_POST['email'];

	if(!setNewToken($email, connection())) {
		addFlash('error', 'Erro ao processar lembrete de nova senha.');
		return header('Location: ' . HOME . '/auth/relembrar-senha');
	}

	addFlash('success', 'Enviamos um email com os procedimentos!');
	return header('Location: ' . HOME . '/auth/login');
}	


require VIEWS . '/' . $page[0] . '/email.phtml';
