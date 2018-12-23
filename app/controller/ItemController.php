<?php
    include_once __DIR__ .'/../repository/RateRepository.php';
    
    include_once __DIR__ .'/../useCase/ItemUseCase.php';
    
    include_once __DIR__ .'/../service/SessionService.php';
    
    class ItemController
    {
        public static function rate($itemId, $rate)
        {
            $item = new ItemUseCase(
                null,
                RateRepository::class,
                SessionService::get('id')
            );
            
            echo $item->rate($itemId, $rate);
        }
    }