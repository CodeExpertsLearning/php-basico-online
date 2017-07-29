<?php

/**
 * Retorna regras de sanitização 
 */
function returnRulesSanitize($data)
{
	if(isset($data['name']))
		$rules['name']        = FILTER_SANITIZE_STRING;

	if(isset($data['description']))
		$rules['description'] = FILTER_SANITIZE_STRING;

	if(isset($data['price']))
		$rules['price']       = FILTER_SANITIZE_STRING;

	if(isset($data['slug']))
		$rules['slug']        = FILTER_SANITIZE_STRING;

	if(isset($data['amount']))
		$rules['amount']	  = FILTER_SANITIZE_STRING;

	if(isset($data['id']))
		$rules['id']          = FILTER_SANITIZE_NUMBER_INT;

	if(isset($data['category_id']))
		$rules['category_id']          = FILTER_SANITIZE_NUMBER_INT;

	return $rules;
}

/**
 * Cria um novo usuário na base de dados.
 */
function create($pdo, $data)
{
   $sql = "INSERT INTO products(
   				category_id,
   				name, 
   				price, 
   				amount,
   				description,
   				slug,
   				created_at, 
   				updated_at
   			) VALUES(
   				:category_id,
				:name,
				:price,
				:amount,
				:description,
				:slug,
				now(),
				now()
   		    )";

    $create = $pdo->prepare($sql);

    $create->bindValue(":category_id", $data['category_id'], PDO::PARAM_INT);
    $create->bindValue(":name", $data['name'], PDO::PARAM_STR);
    $create->bindValue(":price", $data['price'], PDO::PARAM_STR);
    $create->bindValue(":amount", $data['amount'], PDO::PARAM_STR);
    $create->bindValue(":description", $data['description'], PDO::PARAM_STR);
    $create->bindValue(":slug", $data['slug'], PDO::PARAM_STR);
    
    $create->execute();

    return $pdo->lastInsertId();
}

/**
 * Recupera todos os usuários
 */
function getAll($pdo)
{
	$sql = "SELECT 
				p.*,
				c.name as category,
				(SELECT pi.image FROM products_images pi WHERE p.id = pi.product_id LIMIT 1) AS image
			FROM 
				products p 
			LEFT JOIN 
			   categories c 
			ON
			   p.category_id = c.id
		    ORDER BY id DESC";

	$get = $pdo->query($sql);

	return $get->fetchAll(PDO::FETCH_ASSOC);
}

function get($pdo, $id) 
{
	$sql = "SELECT 
				p.id, p.name, p.category_id, p.price, p.description, p.slug, p.amount, pi.id as image_id, pi.image
			FROM products p
			LEFT JOIN 
			    products_images pi
			ON 
			    pi.product_id = p.id
			WHERE p.id = :id";

	$get = $pdo->prepare($sql);
    $get->bindValue(":id", $id, PDO::PARAM_INT);
	$get->execute();
	
	if(!$product = $get->fetchAll(PDO::FETCH_ASSOC)) {
		return false;
	} 

	$return = [];

	foreach($product as $p) {
		$return['id'] = $p['id'];
		$return['name'] = $p['name'];
		$return['category_id'] = $p['category_id'];
		$return['price'] = $p['price'];
		$return['description'] = $p['description'];
		$return['slug'] = $p['slug'];
		$return['amount'] = $p['amount'];

		if($p['image'] && $p['image_id']) {
			$return['images'][] = array('id' => $p['image_id'], 'image' => $p['image']);
		}
	}

 	return $return;
}

function getProductBySlug($pdo, $slug, $count = true) 
{
	$sql = "SELECT p.id, p.name, p.category_id, p.price, p.description, p.slug, p.amount, pi.id as image_id, pi.image FROM products p
			LEFT JOIN 
			    products_images pi
			ON 
			    pi.product_id = p.id WHERE p.slug = :slug";

	$get = $pdo->prepare($sql);
    $get->bindValue(":slug", $slug, PDO::PARAM_STR);
	$get->execute(); 

	if($count) {
		return $get->rowCount();	
	} else {
		$return = [];

		foreach($get->fetchAll(PDO::FETCH_ASSOC) as $p) {
			$return['id'] = $p['id'];
			$return['name'] = $p['name'];
			$return['category_id'] = $p['category_id'];
			$return['price'] = $p['price'];
			$return['description'] = $p['description'];
			$return['slug'] = $p['slug'];
			$return['amount'] = $p['amount'];

			if($p['image'] && $p['image_id']) {
				$return['images'][] = array('id' => $p['image_id'], 'image' => $p['image']);
			}
		}

	 	return $return;
	}
	
}

function update($pdo, $data)
{
	$sql = "UPDATE products SET";


	$sqlSet = '';
	
	if(isset($data['category_id']) && $data['category_id']) {
		$sqlSet .= " category_id = :category_id";
	}

	if(isset($data['name']) && $data['name']) {
		$sqlSet .=  $sqlSet ? ", name = :name" : "name = :name";
	}

	if(isset($data['price']) && $data['price']) {
		$sqlSet .= $sqlSet ? ", price = :price" : " price = :price";
	}


	if(isset($data['amount']) && $data['amount']) {
		$sqlSet .= $sqlSet ?  ", amount = :amount" : " amount = :amount";
	}

	if(isset($data['description']) && $data['description']) {
		$sqlSet .= $sqlSet ?  ", description = :description" : " description = :description";
	}

	if(isset($data['slug']) && $data['slug']) {
		$sqlSet .= $sqlSet ?  ", slug = :slug" : " slug = :slug";
	}

	$sql = $sqlSet ? $sql . $sqlSet . ", updated_at = NOW() WHERE id = :id" : $sql . " WHERE id = :id";

	$update = $pdo->prepare($sql);

	if(isset($data['category_id']) && $data['category_id']){
		$update->bindValue(":category_id", $data['category_id'], PDO::PARAM_STR);
	}
	
	if(isset($data['name']) && $data['name']){
		$update->bindValue(":name", $data['name'], PDO::PARAM_STR);
	}

	if(isset($data['price']) && $data['price']){
		$update->bindValue(":price", $data['price'], PDO::PARAM_STR);
	}

	if(isset($data['amount']) && $data['amount']) {
		$update->bindValue(":amount", $data['amount'], PDO::PARAM_STR);
	}
	
	if(isset($data['description']) && $data['description']) {
		$update->bindValue(":description", $data['description'], PDO::PARAM_STR);
	}

	if(isset($data['slug']) && $data['slug']) {
		$update->bindValue(":slug", $data['slug'], PDO::PARAM_STR);
	}

	$update->bindValue(":id", $data['id'], PDO::PARAM_INT);

	return $update->execute();
}

function delete($pdo, $id)
{
	$sql = "DELETE FROM products WHERE id = :id";

	$delete = $pdo->prepare($sql);

	$delete->bindValue(":id", $id, PDO::PARAM_INT);

	return $delete->execute();
}