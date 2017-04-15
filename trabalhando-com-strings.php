<?php 
$name = "Nanderson";

/**
 * Contando caracteres
 */
// print strlen($name);

/*
Pegando pedaços especificos 
de uma string
 */
// $name = substr($name, 0, 5);

/**
 * Fazendo replace 
 * em strings
 */
$name = str_replace("N", "T", $name);

/**
 * Colocando String 
 * em Maiusculo
 */
$name = strtoupper($name);

/**
 * Colocando String 
 * em Minusculo
 */
$name = strtolower($name);

print $name;

