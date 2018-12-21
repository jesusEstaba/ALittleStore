<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    //declare(strict_types=1);
    
    /**
     * 
     * 
     */
    
    session_start();
    
    if (!isset($_SESSION['id'])) {
        $_SESSION['id'] = md5(time() . rand(1, 1000));
        $_SESSION['pocket'] = 100;
    }
    
    /**
     * This is in sustitution a Router
     */
    
    $url = explode('/', $_SERVER['REQUEST_URI']);
    $urlAction = $url[1];
     
    switch($urlAction)
    {
        case '':
            include_once 'repository/ItemRepository.php';
            include_once 'repository/CartRespository.php';
            
            $items = ItemRepository::getWithRate($_SESSION['id']);
            $slots = CartRepository::getSlots($_SESSION['id']);
            $pocket = $_SESSION['pocket'];
            
            include 'views/store.php';
        break;
        
        case 'add':
            include_once 'repository/CartRespository.php';
            
            CartRepository::addItem(
                $_SESSION['id']
                , $url[2]
                , $url[3]
            );
        break;
        
        case 'remove':
            include_once 'repository/CartRespository.php';
            
            CartRepository::removeStock($_SESSION['id'], $url[2]);
        break;
        
        case 'rate':
            include_once 'repository/RateRepository.php';
            
            echo RateRepository::add(
                $_SESSION['id']
                , $url[2]
                , $url[3]
            );
        break;
        
        case 'checkout':
            include_once 'repository/CartRespository.php';
            
            $slots = CartRepository::getSlots($_SESSION['id']);
            $total = CartRepository::getTotal($_SESSION['id']);
            $pocket = $_SESSION['pocket'];
            
            include 'views/checkout.php';
        break;
        
        case 'pay':
            include_once 'repository/SellRepository.php';
            
            $total = SellRepository::pay($_SESSION['id'], $_SESSION['pocket'], $_POST['method']);
            $_SESSION['pocket'] -= $total;
            
            echo $total;
        break;
        
        default:
            #404
    }
    
?>