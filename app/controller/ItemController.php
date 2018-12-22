<?php
    include_once __DIR__ .'/../repository/RateRepository.php';
    
    include_once __DIR__ .'/../service/SessionService.php';
    
    class ItemController
    {
        public static function rate($itemId, $rate)
        {
  
            $sessionId = SessionService::get('id');
            
            $isRated = RateRepository::getWhere([
                'session_id' => $sessionId, 
                'item_id' => $itemId
            ]);
            
            if (count($isRated) === 0) {
                RateRepository::save([
                    'session_id' => $sessionId, 
                    'item_id' => $itemId,
                    'rate' => $rate,
                ]);
            }
            
            $rate = RateRepository::avg('rate', 'item_id = ' .  $itemId)[0];
            
            if ($rate->average == null) {
                echo 0;
                return 0;
            }
            
            echo $rate->average;
        }
    }