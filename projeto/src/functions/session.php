<?php

function sessionStart()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}

function addFlash($key, $message)
{
    sessionStart();

    $_SESSION[$key] = $message;
}

function getFlash($key)
{
    sessionStart();

    if(!isset($_SESSION[$key])) {
        return false;
    }

    $msg = $_SESSION[$key];

    unset($_SESSION[$key]);

    return $msg;
}