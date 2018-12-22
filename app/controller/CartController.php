<?php
    
    include_once __DIR__ .'/../service/SessionService.php';
    
    include_once __DIR__ .'/../repository/CartRepository.php';
    include_once __DIR__ .'/../repository/ItemRepository.php';
    
    include_once __DIR__ .'/../useCase/CartUseCase.php';
    
    class CartController
    {
        private static function getCart()
        {
            return new CartUseCase(
                CartRepository::class,
                ItemRepository::class,
                SessionService::get('id')
            );
        }
        
        public static function add($itemId, $quantity)
        {
            $cart = static::getCart();
            
            $cart->addItem($itemId, $quantity);
        }
        
        public static function remove($itemId)
        {
            $cart = static::getCart();
            
            $cart->removeStock($itemId);
        }
    }