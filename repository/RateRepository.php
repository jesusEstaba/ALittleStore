<?php  
    require_once 'Repository.php';


    class RateRepository extends Repository
    {
        protected static $_table = 'rates';
        
        public static function add($sessionId, $itemId, $rate)
        {
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
                return 0;
            }
            
            return $rate->average;
        }
    }
    