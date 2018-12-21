<?php
    include_once __DIR__ .'/../repository/RateRepository.php';
    
    include_once __DIR__ .'/../service/SessionService.php';
    
    class ItemController
    {
        public static function rate($itemId, $rate)
        {
            echo RateRepository::add(
                SessionService::get('id')
                , $itemId
                , $rate
            );
        }
    }