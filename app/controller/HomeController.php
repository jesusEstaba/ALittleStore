<?php
    
    include_once __DIR__ .'/../service/SessionService.php';
    
    include_once __DIR__ .'/../repository/CartRepository.php';
    include_once __DIR__ .'/../repository/ItemRepository.php';
    include_once __DIR__ .'/../repository/RateRepository.php';
    
    include_once __DIR__ .'/../useCase/CartUseCase.php';
    include_once __DIR__ .'/../useCase/ItemUseCase.php';

    class HomeController
    {
        public static function index()
        {
            $sessionId = SessionService::get('id');
            $pocket = SessionService::get('pocket');
            
            $item = new ItemUseCase(
                ItemRepository::class,
                RateRepository::class,
                $sessionId
            );
            
            $cart = new CartUseCase(
                CartRepository::class,
                ItemRepository::class,
                $sessionId
            );
            
            $items = $item->getItemsWithRate();
            $slots = $cart->getSlots();
            
            view('store', compact('items', 'slots', 'pocket'));
        }
    }