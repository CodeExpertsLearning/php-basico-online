<?php

$fruits = ['laranja', 'maçã', 'banana', 'pera'];

#While
$num = 1;
$i = 0;

// while($i < $num) {
// 	print $fruits[$i] . PHP_EOL;
// 	$i++;
// }
// 
#Do While

// do {
//   print $fruits[$i] . PHP_EOL;
//   $i++;
// }while ($i < $num);

#For

// for($i = 0; $i < count($fruits); $i++) {
// 	print $fruits[$i] . PHP_EOL;
// }

#Foreach

foreach($fruits as $key => $fruit) {
	print $key . ' - ' . $fruit . PHP_EOL;
}



