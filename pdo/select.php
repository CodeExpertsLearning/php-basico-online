<?php
require __DIR__ . '/connection.php';
 
#products
#Busco, de forma simples e direta 
#todos os produtos.
#
$result = $pdo->query("SELECT * FROM products");

#Array Associativo
$result = $result->fetchAll(PDO::FETCH_ASSOC); 

foreach($result as $r)
{
	print $r['id'] . '<br>';

	print $r['name'] . '<br>';
	print $r['price'] . '<br>';
	print '<hr>';
}