<?php  
    require_once 'Repository.php';
    require_once 'CartRespository.php';


    class SellRepository extends Repository
    {
        protected static $_table = 'sells';
        
        public static function pay($sessionId, $sessionAmount, $method)
        {
            $total = CartRepository::getTotal($sessionId);
            
            if ($method==='ups') {
                $total += 5;
            }
            
            if ($total > $sessionAmount)
            {
                return 0;
            }
            
            static::save([
                'amount' => $total,
                'session_id' => $sessionId,
                'method' => $method,
            ]);
            CartRepository::clear($sessionId);
            
            return $total;
        }
    }
    