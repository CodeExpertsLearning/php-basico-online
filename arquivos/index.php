<?php 

// fopen -> Ele abre o arquivo que queremos manipular
// fwrite -> Ele escreve um conteudo passado para o arquivo.
// fread -> Ele lê o conteudo do arquivo 
// fclose -> Ele fecha a leitura/manipulacao daquele arquivo aberto pelo 
//           fopen

$f = __DIR__ . '/exemplo2.txt';

$file = fopen($f, 'a+');

// fwrite($file, "Conteúdo escrito via PHP" . PHP_EOL);

$content = fread($file, filesize($f));

fclose($file);

print $content;





