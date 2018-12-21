<?php  
    require_once 'Repository.php';
    require_once 'ItemRepository.php';

    class CartRepository extends Repository
    {
        protected static $_table = 'cart_slots';
        
        public static function getSlots($sessionId)
        {
            $slots = static::getWhere('session_id', $sessionId);
            
            foreach ($slots as $slot)
            {
                $slot->item = ItemRepository::getById($slot->item_id);
            }
            
            return $slots;
        }
        
        public static function addItem($sessionId, $itemId, $quantity)
        {
            $slot = static::getWhere([
                'item_id' => $itemId,
                'session_id' => $sessionId,
            ]);
            
            if ($slot)
            {
                $slot = $slot[0];
                
                static::update(
                    $itemId
                    , ['quantity' => $slot->quantity + $quantity]
                    , 'item_id=' . $slot->item_id . ' AND session_id="' . $sessionId . '"'
                );
            
                return $itemId;
            }
            
            return static::save([
                'item_id' => $itemId,
                'quantity' => $quantity,
                'session_id' => $sessionId,
            ]);
        }
        
        public static function removeStock($sessionId, $itemId)
        {
            static::destroy(
                'item_id=' . $itemId 
                . ' AND session_id="' . $sessionId . '"'
            );
        }
        
        public static function getTotal($sessionId)
        {
            $cart = static::getSlots($sessionId);
          
            $total = 0;
            
            foreach ($cart as $stock)
            {
                $total += $stock->item->price * $stock->quantity;
            }
            
            return $total;
        }
        
        public static function clear($sessionId)
        {
            static::destroy("session_id='{$sessionId}'");
        }
    }
    