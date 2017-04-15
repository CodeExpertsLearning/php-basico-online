<?php
/**
 * Faz a validação do email
 */
function validateEmail($email) {
	return filter_var($email, FILTER_VALIDATE_EMAIL);	
}

/**
 * Valida os campos em branco
 * para que não passem.
 */
function fieldsRequired($data) {
	foreach($data as $key => $d) {
		if(!$data[$key]) {
			return false;
		}
	}
	return true;
}

/**
 * Valida o tamanho da senha
 */
function validateLengthPassword($password)
{
	return strlen($password) >= 6;
}