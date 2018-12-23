<?php
    
    class PayUseCase
    {
        public function __construct(
            $sellRepository,
            $sessionService,
            $cart
        )
        {
            $this->sellRepository = $sellRepository;
            $this->cart = $cart;
            $this->sessionService = $sessionService;
            $this->sessionId =  $this->sessionService::get('id');
        }
        
        public function sell($shippingMethod)
        {
            $total = $this->cart->getTotal();
            $pocket = $this->sessionService::get('pocket');
            
            if ($shippingMethod==='ups') 
            {
                $total += 5;
            }
            
            if ($total > $pocket)
            {
                return 0;
            }
            
            $this->sellRepository::save([
                'amount' => $total,
                'session_id' => $this->sessionId,
                'method' => $shippingMethod,
            ]);
                
            $this->sessionService::set('pocket', $pocket - $total);
            $this->cart->clear();
            
            return $total;
        }
    }