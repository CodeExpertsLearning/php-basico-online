<?php 

function saveImages($data, $pdo)
{
	$sql = "INSERT INTO products_images(
				product_id, 
				image, 
				created_at,
				updated_at)
			VALUES (
				:product_id,
				:image,
				now(),
				now()
			)";

	$create = $pdo->prepare($sql);
	$create->bindValue(":image", $data['image'], PDO::PARAM_STR);
	$create->bindValue(":product_id", $data['product_id'], PDO::PARAM_STR);

	return $create->execute();
}

function getImage($id, $pdo)
{
	$sql = "SELECT id, image FROM products_images WHERE id = :id";

	$select = $pdo->prepare($sql);
	$select->bindValue(":id", $id, PDO::PARAM_STR);

	$select->execute();

	return $select->fetch(PDO::FETCH_ASSOC);
}

function deleteImage($data, $pdo)
{
	$sql = "DELETE FROM products_images WHERE id = :id AND product_id = :product_id";

	$delete = $pdo->prepare($sql);
	$delete->bindValue(":id", $data['image_id'], PDO::PARAM_INT);
	$delete->bindValue(":product_id", $data['product_id'], PDO::PARAM_INT);

	return $delete->execute();
}