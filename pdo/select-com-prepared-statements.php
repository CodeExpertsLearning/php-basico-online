<?php
require __DIR__ . '/connection.php';
$id = $_GET['id'];
$price = $_GET['price'];
#products
#Busco, de forma simples e direta 
#todos os produtos.
#

$sql = "SELECT * FROM products WHERE id = :id AND price > :price";

$result = $pdo->prepare($sql);
$result->bindValue(":id", $id, PDO::PARAM_INT);
$result->bindValue(":price", $price, PDO::PARAM_INT);
$result->execute();

#Array Associativo
$result = $result->fetchAll(PDO::FETCH_ASSOC); 

foreach($result as $r)
{
	print $r['id'] . '<br>';

	print $r['name'] . '<br>';
	print $r['price'] . '<br>';
	print '<hr>';
}