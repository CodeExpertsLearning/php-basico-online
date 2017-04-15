<?php
require __DIR__ . '/connection.php';
 
#products
#Busco, de forma simples e direta 
#todos os produtos.
#

$name = "Novo Produto CEL";
$price = 19.96;

$sql = "INSERT INTO 
			products(name, price) 
		VALUES(
			:name,
			:price
		)
	";

$insert = $pdo->prepare($sql);

$insert->bindValue(":name", $name, PDO::PARAM_STR);
$insert->bindValue(":price", $price, PDO::PARAM_STR);

if($insert->execute()) {
	print 'Dado inserido';
} else {
	print 'Erro ao inserir dados!';
}

