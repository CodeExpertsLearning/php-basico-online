<?php

/**
 * Valida os campos em branco
 * para que não passem.
 */
function sanitizerString($data, $filters)
{
	return filter_var_array($data, $filters);
}