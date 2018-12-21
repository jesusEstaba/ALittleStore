<?php
    
    include_once __DIR__ .'/../repository/CartRespository.php';
    include_once __DIR__ .'/../repository/SellRepository.php';
    
    include_once __DIR__ .'/../service/SessionService.php';
    
    class CheckoutController
    {
        public static function index()
        {
            $slots = CartRepository::getSlots(SessionService::get('id'));
            $total = CartRepository::getTotal(SessionService::get('id'));
            $pocket = SessionService::get('pocket');
            
            view('checkout', compact('slots', 'total', 'pocket'));
        }
        
        public static function pay($paymentMethod)
        {
            $total = SellRepository::pay(
                SessionService::get('id'), 
                SessionService::get('pocket'), 
                $paymentMethod
            );
            $pocket = SessionService::get('pocket');
            
            //no se esta validando si es suficiente
            SessionService::set('pocket', $pocket - $total);
            
            echo $total;
        }
    }
    