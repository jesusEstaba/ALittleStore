<?php
    
    class CartUseCase
    {
        public function __construct(
            $cartRepository,
            $itemRepository,
            $sessionId
        )
        {
            $this->cartRepository = $cartRepository;
            $this->itemRepository = $itemRepository;
            $this->sessionId = $sessionId;
        }
        
        public function getTotal()
        {
            $slots = $this->getSlots();
          
            $total = 0;
            
            foreach ($slots as $stock)
            {
                $total += $stock->item->price * $stock->quantity;
            }
            
            return $total;
        }
        
        public function getSlots() 
        {
            $slots = $this->cartRepository::getWhere('session_id', $this->sessionId);
            
            foreach ($slots as $slot)
            {
                $slot->item = $this->itemRepository::getById($slot->item_id);
            }

            return $slots;
        }
        
        public function addItem($itemId, $quantity)
        {
            $slot = $this->cartRepository::getWhere([
                'item_id' => $itemId,
                'session_id' => $this->sessionId,
            ]);
            
            if ($slot)
            {
                $slot = $slot[0];
                
                $this->cartRepository::update(
                    $itemId
                    , ['quantity' => $slot->quantity + $quantity]
                    , 'item_id=' . $slot->item_id . ' AND session_id="' . $this->sessionId . '"'
                );
            
                return $itemId;
            }
            
            return $this->cartRepository::save([
                'item_id' => $itemId,
                'quantity' => $quantity,
                'session_id' => $this->sessionId,
            ]);
        }
        
        public function removeStock($itemId)
        {
            $this->cartRepository::destroy(
                'item_id=' . $itemId 
                . ' AND session_id="' . $this->sessionId . '"'
            );
        }
        
        public function clear()
        {
            $this->cartRepository::destroy("session_id='{$this->sessionId}'");
        }
    }
    