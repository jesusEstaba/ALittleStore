<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    //declare(strict_types=1);
    
    /**
     * This is in sustitution a Router
     */
    
    $url = explode('/', $_SERVER['REQUEST_URI']);
    $urlAction = $url[1];
    
    spl_autoload_register(function ($clase) {
        require 'app/controller/' . $clase . '.php';
    });
    
    function view($name, $data = []) {
        extract($data);
        require('views/_head.php');
        require('views/' . $name . '.php');
        require('views/_footer.php');
    }
     
    switch($urlAction)
    {
        case '':
            HomeController::index();
        break;
        
        case 'add':
            CartController::add($url[2], $url[3]);
        break;
        
        case 'remove':
            CartController::remove($url[2]);
        break;
        
        case 'rate':
            ItemController::rate($url[2], $url[3]);
        break;
        
        case 'checkout':
            CheckoutController::index();
        break;
        
        case 'pay':
            //$_POST['method'] -> Payment Method
            CheckoutController::pay($_POST['method']);
        break;
        
        default:
            #404
    }
    
?>