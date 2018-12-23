<?php

    class ItemUseCase
    {
        public function __construct(
            $itemRepository,
            $rateRepository,
            $sessionId
        )
        {
            $this->itemRepository = $itemRepository;
            $this->rateRepository = $rateRepository;
            $this->sessionId = $sessionId;
        }
        
        public function getItemsWithRate()
        {
            $items = $this->itemRepository::get();
            
            foreach ($items as $item)
            {
                $rate = $this->rateRepository::avg('rate', 'item_id = ' .  $item->id)[0];
                $item->rate = $rate->average;
                
                
                $isRated = $this->rateRepository::getWhere([
                    'session_id' => $this->sessionId, 
                    'item_id' => $item->id
                ]);
                
                $item->is_rated = count($isRated) > 0;
            }
            
            return $items;
        }
        
        public function rate($itemId, $rate)
        {
            $isRated = $this->rateRepository::getWhere([
                'session_id' => $this->sessionId, 
                'item_id' => $itemId
            ]);
            
            if (!count($isRated)) {
                $this->rateRepository::save([
                    'session_id' => $this->sessionId, 
                    'item_id' => $itemId,
                    'rate' => $rate,
                ]);
            }
            
            $rate = $this->rateRepository::avg('rate', 'item_id = ' .  $itemId)[0];
            
            if ($rate->average == null) {
                return 0;
            }
            
            return $rate->average;
        }
    }