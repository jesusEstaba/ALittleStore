<?php
    
    include_once __DIR__ .'/../repository/CartRespository.php';
    
    include_once __DIR__ .'/../service/SessionService.php';
    
    class CartController
    {
        public static function add($itemId, $quantity)
        {
            CartRepository::addItem(
                SessionService::get('id')
                , $itemId
                , $quantity
            );
        }
        
        public static function remove($itemId)
        {
            CartRepository::removeStock(SessionService::get('id'), $itemId);
        }
    }