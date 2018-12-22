<?php
    include_once __DIR__ .'/../service/SessionService.php';
    
    include_once __DIR__ .'/../repository/CartRepository.php';
    include_once __DIR__ .'/../repository/ItemRepository.php';
    include_once __DIR__ .'/../repository/SellRepository.php';
    
    include_once __DIR__ .'/../useCase/CartUseCase.php';
    
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
            $sessionId=SessionService::get('id'); 
            $pocket = SessionService::get('pocket');
            $method=$paymentMethod;
            
            $cart = static::getCart();
            
            $total = $cart->getTotal();
            
            if ($method==='ups') {
                $total += 5;
            }
            
            if ($total > $pocket)
            {
                $total = 0;
            }
            
            
            SellRepository::save([
                'amount' => $total,
                'session_id' => $sessionId,
                'method' => $method,
            ]);
            
            $cart->clear();
            
            SessionService::set('pocket', $pocket - $total);
            
            echo $total;
        }
    }
    