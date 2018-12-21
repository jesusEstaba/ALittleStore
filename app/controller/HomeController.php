<?php
    
    include_once __DIR__ .'/../repository/ItemRepository.php';
    include_once __DIR__ .'/../repository/CartRespository.php';
    
    include_once __DIR__ .'/../service/SessionService.php';

    class HomeController
    {
        public static function index()
        {
            $items = ItemRepository::getWithRate(SessionService::get('id'));
            $slots = CartRepository::getSlots(SessionService::get('id'));
            $pocket = SessionService::get('pocket');
            
            include __DIR__ .'/../../views/store.php';
        }
    }