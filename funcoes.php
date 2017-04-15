<?php

// function hello()
// {
//    return 'Hello World';
// }

function soma($a, $b)
{
	$result = $a + $b;

	if($result == 40) {
		return "Você foi sorteado!";
	}

	return $result;
}

print soma(10, 10);