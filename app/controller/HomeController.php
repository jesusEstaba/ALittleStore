<?php
    
    include_once __DIR__ .'/../service/SessionService.php';
    
    include_once __DIR__ .'/../repository/CartRepository.php';
    include_once __DIR__ .'/../repository/ItemRepository.php';
    include_once __DIR__ .'/../repository/RateRepository.php';
    
    include_once __DIR__ .'/../useCase/CartUseCase.php';

    class HomeController
    {
        public static function index()
        {
            $sessionId = SessionService::get('id');
            $pocket = SessionService::get('pocket');
            
            $items = static::getWithRate($sessionId);//@refactor
            
            $cart = new CartUseCase(
                CartRepository::class,
                ItemRepository::class,
                $sessionId
            );
            
            $slots = $cart->getSlots();
            
            view('store', compact('items', 'slots', 'pocket'));
        }
        
        public static function getWithRate($sessionId)
        {
            $items = ItemRepository::get();
            
            foreach ($items as $item)
            {
                $rate = RateRepository::avg('rate', 'item_id = ' .  $item->id)[0];
                $item->rate = $rate->average;
                
                
                $isRated = RateRepository::getWhere([
                    'session_id' => $sessionId, 
                    'item_id' => $item->id
                ]);
                
                $item->is_rated = count($isRated) > 0;
            }
            
            return $items;
        }
    }