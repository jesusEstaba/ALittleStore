<?php  
    require_once 'Repository.php';
    require_once 'RateRepository.php';


    class ItemRepository extends Repository
    {
        protected static $_table = 'items';
        
        public static function getWithRate($sessionId)
        {
            $items = static::get();
            
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
    