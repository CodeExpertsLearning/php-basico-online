<?php

function isUrl($match)
{
    return preg_match("/{$match}/", $_SERVER['REQUEST_URI']);
}