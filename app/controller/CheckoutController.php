<?php
    include_once __DIR__ .'/../service/SessionService.php';
    
    include_once __DIR__ .'/../repository/CartRepository.php';
    include_once __DIR__ .'/../repository/ItemRepository.php';
    include_once __DIR__ .'/../repository/SellRepository.php';
    
    include_once __DIR__ .'/../useCase/CartUseCase.php';
    include_once __DIR__ .'/../useCase/PayUseCase.php';
    
    class CheckoutController
    {
        public static function getCart()
        {
            return new CartUseCase(
                CartRepository::class,
                ItemRepository::class,
                SessionService::get('id')
            );
        }
        
        public static function index()
        {
            $cart = static::getCart();
            
            $slots = $cart->getSlots();
            $total = $cart->getTotal();
            $pocket = SessionService::get('pocket');
            
            view('checkout', compact('slots', 'total', 'pocket'));
        }
        
        public static function pay($paymentMethod)
        {
            $pay = new PayUseCase(
                SellRepository::class,
                SessionService::class,
                static::getCart()
            );
            
            echo $pay->sell($paymentMethod);
        }
    }
    