<?php

/**
 * Retorna regras de sanitização 
 */
function returnRulesSanitize($data)
{
    $rules = [];

	if(isset($data['name']))
        $rules['name'] = FILTER_SANITIZE_STRING;

	if(isset($data['email']))
		$rules['email'] = FILTER_SANITIZE_STRING;

	if(isset($data['password']))
		$rules['password'] = FILTER_SANITIZE_STRING;

	if(isset($data['id']))
        $rules['id'] = FILTER_SANITIZE_NUMBER_INT;

	return $rules;
}

/**
 * Cria um novo usuário na base de dados.
 */
function create($pdo, $data)
{
   $sql = "INSERT INTO users(
   				name, 
   				email, 
   				password, 
   				created_at, 
   				updated_at)
   		    VALUES(
				:name,
				:email,
				:password,
				now(),
				now()
   		    )";

    $create = $pdo->prepare($sql);
    $create->bindValue(":name", $data['name'], PDO::PARAM_STR);
    $create->bindValue(":email", $data['email'], PDO::PARAM_STR);
    $create->bindValue(":password", sha1($data['password'] . APP_KEY), PDO::PARAM_STR);

    return $create->execute();
}

/**
 * Recupera todos os usuários
 */
function getAll($pdo)
{
	$sql = "SELECT * FROM users ORDER BY id DESC";

	$get = $pdo->query($sql);

	return $get->fetchAll(PDO::FETCH_ASSOC);
}

function get($pdo, $id) 
{
	$sql = "SELECT id, name, email FROM users WHERE id = :id";

	$get = $pdo->prepare($sql);
    $get->bindValue(":id", $id, PDO::PARAM_INT);
	$get->execute();
	
	if(!$users = $get->fetch(PDO::FETCH_ASSOC)) {
		return false;
	} 

	return $users;
}

function getUserByEmail($pdo, $email) 
{
	$sql = "SELECT id, name, email FROM users WHERE email = :email";

	$get = $pdo->prepare($sql);
    $get->bindValue(":email", $email, PDO::PARAM_INT);
	$get->execute(); 

	return $get->rowCount();
}

function update($pdo, $data)
{
	$sql = "UPDATE users SET";


	$sqlSet = '';
	
	if(isset($data['name']) && $data['name']) {
		$sqlSet .= " name = :name";
	}

	if(isset($data['email']) && $data['email']) {
		$sqlSet .= $sqlSet ? ", email = :email" : " email = :email";
	}


	if(isset($data['password']) && $data['password']) {
		$sqlSet .= $sqlSet ?  ", password = :password" : " password = :password";
	}

	$sql = $sqlSet ? $sql . $sqlSet . " WHERE id = :id" : $sql . " WHERE id = :id";

	$update = $pdo->prepare($sql);

	if(isset($data['name']) && $data['name']){
		$update->bindValue(":name", $data['name'], PDO::PARAM_STR);
	}


	if(isset($data['email']) && $data['email']){
		$update->bindValue(":email", $data['email'], PDO::PARAM_STR);
	}


	if(isset($data['password']) && $data['password']) {
		$update->bindValue(":password", sha1($data['password'] . APP_KEY), PDO::PARAM_STR);
	}

	$update->bindValue(":id", $data['id'], PDO::PARAM_INT);

	return $update->execute();
}

function delete($pdo, $id)
{
	$sql = "DELETE FROM users WHERE id = :id";

	$delete = $pdo->prepare($sql);

	$delete->bindValue(":id", $id, PDO::PARAM_INT);

	return $delete->execute();
}



















