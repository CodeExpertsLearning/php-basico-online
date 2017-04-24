<?php
chdir(dirname(__DIR__));

require 'src/config.php';
require 'src/functions/connection.php';
require 'src/functions/sanitizer.php';
require 'src/functions/validator.php';
require 'src/functions/session.php';
require 'src/functions/url_tools.php';

$page = isset($_SERVER['REQUEST_URI'])? substr($_SERVER['REQUEST_URI'], 1) : 'home';

$page = explode('/', $page);

if($page[0] == 'admin') {

    sessionStart();

    if(!isset($_SESSION['user'])) {
        addFlash('warning', 'É preciso realizar o login para acessar o recurso: ' . $page[1]);
        return header('Location: ' . HOME . '/auth/login');
    }

    $module = isset($page[1]) ? $page[1] : 'dashboard';

    if($page[1] == 'users') {
        require 'src/functions/admin/users.php';
    }

    if($page[1] == 'products') {
        require 'src/functions/admin/products.php';
        require 'src/functions/admin/products_images.php';
        require 'src/functions/admin/categories.php';
        require 'src/functions/upload.php';

    }

    if($page[1] == 'categories') {
        require 'src/functions/admin/categories.php';
    }

    if(!is_file($file = 'src/routes/' . $page[0] . '/' . $page[1] . '.route.php')
        || !isset($page[2]))
    {
        require VIEWS . '/errors/404.phtml';
        die;
    }

    require $file;
}

if($page[0] == 'auth') {
   if($page[1] == 'login') {
       require 'src/functions/auth/login.php';
       require 'src/routes/' . $page[0] . '/' . $page[1] . '.route.php';
   }

   if($page[1] == 'logout') {
     sessionStart();
     session_destroy();
     unset($_SESSION['user']);

     header('Location: ' . HOME . '/auth/login');
   }
   
   if($page[1] == 'relembrar-senha') {
       require 'src/functions/auth/remember-password.php';
       require 'src/routes/' . $page[0] . '/remember-password.route.php';
   }


   if($page[1] == 'atualizar-senha') {
       require 'src/routes/' . $page[0] . '/update-password.route.php';
   }
}

