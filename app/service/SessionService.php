<?php
    class SessionService
    {
        private static function constructor()
        {
            if (!isset($_SESSION)) {
                session_start();    
            }
    
            if (!isset($_SESSION['id'])) {
                $_SESSION['id'] = md5(time() . rand(1, 1000));
                $_SESSION['pocket'] = 100;
            }
        }
        
        public static function get($name)
        {
            static::constructor();
            
            return $_SESSION[$name];
        }
        
        public static function set($name, $value)
        {
            static::constructor();
            
            $_SESSION[$name] = $value;
        }
    }