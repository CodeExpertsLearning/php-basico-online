<?php

/**
 * Retorna regras de sanitização 
 */
function returnRulesSanitizeCategories()
{
	return [
		'name' => FILTER_SANITIZE_STRING, 
		'description' => FILTER_SANITIZE_STRING,
		//'id'       => FILTER_SANITIZE_NUMBER_INT
	];
}

/**
 * Cria um novo usuário na base de dados.
 */
function createCategory($pdo, $data)
{
   $sql = "INSERT INTO categories(
   				name, 
   				description, 
   				slug, 
   				created_at, 
   				updated_at)
   		    VALUES(
				:name,
				:description,
				:slug,
				now(),
				now()
   		    )";

    $create = $pdo->prepare($sql);
    $create->bindValue(":name", $data['name'], PDO::PARAM_STR);
    $create->bindValue(":description", $data['description'], PDO::PARAM_STR);
    $create->bindValue(":slug", $data['slug'], PDO::PARAM_STR);

    return $create->execute();
}

/**
 * Recupera todos os categorias
 */
function getAllCategories($pdo)
{
	$sql = "SELECT * FROM categories ORDER BY id DESC";

	$get = $pdo->query($sql);

	return $get->fetchAll(PDO::FETCH_ASSOC);
}

function getCategory($pdo, $id) 
{
	$sql = "SELECT id, name, description, slug FROM categories WHERE id = :id";

	$get = $pdo->prepare($sql);
    $get->bindValue(":id", $id, PDO::PARAM_INT);
	$get->execute();
	
	if(!$categories = $get->fetch(PDO::FETCH_ASSOC)) {
		return false;
	} 

	return $categories;
}

function updateCategory($pdo, $data)
{
    var_dump($data);
	$sql = "UPDATE categories SET";


	$sqlSet = '';
	
	if(isset($data['name']) && $data['name']) {
		$sqlSet .= " name = :name";
	}

	if(isset($data['description']) && $data['description']) {
		$sqlSet .= $sqlSet ? ", description = :description" : " description = :description";
	}

	$sql = $sqlSet ? $sql . $sqlSet . " WHERE id = :id" : $sql . " WHERE id = :id";

	$update = $pdo->prepare($sql);

	if(isset($data['name']) && $data['name']){
		$update->bindValue(":name", $data['name'], PDO::PARAM_STR);
	}


	if(isset($data['description']) && $data['description']){
		$update->bindValue(":description", $data['description'], PDO::PARAM_STR);
	}

	$update->bindValue(":id", $data['id'], PDO::PARAM_INT);

	return $update->execute();
}

function deleteCategory($pdo, $id)
{
	$sql = "DELETE FROM categories WHERE id = :id";

	$delete = $pdo->prepare($sql);

	$delete->bindValue(":id", $id, PDO::PARAM_INT);

	return $delete->execute();
}



















