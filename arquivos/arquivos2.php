<?php 
$f = __DIR__ . '/exemplo3.txt';

file_put_contents($f, "<br> Outro Conteudo",  FILE_APPEND);

$content = file_get_contents($f);


print $content;