<?php
    
    class Repository
    {
        protected static $_table;
        
        protected static function getConnection()
        {
            try
            {
                $connection = new PDO(
                    'mysql:host=localhost;dbname=c9'
                    , 'rakzodia'
                    , ''
                );
	            
	            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(PDOException $e)
            {
            	echo 'ERROR: ' . $e->getMessage();
            }
            
	        return $connection;
        }
        
        public static function get()
        {
            $result = static::getConnection()
                ->query('SELECT * FROM ' . static::$_table)
                ->fetchAll(PDO::FETCH_ASSOC);
                
            return static::convertToCollection($result);
        }
        
        public static function getWhere($columnArray = '', $value = '')
        {
            
            if (!is_array($columnArray)) 
            {
                $columnArray = [$columnArray => $value];
            }
            
            $columns = '';

            foreach ($columnArray as $column => $value)
            {
                if ($columns === '') {
                    $columns = $column . '= :' . $column;
                } else {
                    $columns .= ' AND ' . $column . '= :' . $column;
                }
            }
            
            $result = static::getConnection()
                    ->prepare(
                        'SELECT * FROM ' . static::$_table 
                        . ' WHERE ' . $columns
                    );
            
            $result->execute($columnArray);
            
            return static::convertToCollection($result->fetchAll(PDO::FETCH_ASSOC));
            
        }
        
        public static function getById($id)
        {
            return static::getWhere('id', $id)[0];
        }
        
        public static function save($data)
        {
            $columns = '';
            $values = '';
            
            foreach ($data as $column => $value)
            {
                if ($columns === '') {
                    $columns = $column;
                    $values = ':' . $column;
                } else {
                    $columns .= ',' . $column;
                    $values .= ', :' . $column;
                }
            }
            
            $connection = static::getConnection();
            
            $connection
                ->prepare(
                    'INSERT INTO ' . static::$_table 
                    . ' (' . $columns . ') VALUES (' . $values . ')'
                )
                ->execute($data);
            
            return $connection->lastInsertId();
        }
        
        public static function update($id, $data, $where)
        {
            $columns = '';

            foreach ($data as $column => $value)
            {
                if ($columns === '') {
                    $columns = $column . '= :' . $column;
                } else {
                    $columns .= ',' . $column . '= :' . $column;
                }
            }
            
            $connection = static::getConnection();
            
            $result = $connection->prepare(
                    'UPDATE ' . static::$_table 
                    . ' SET ' . $columns . ' WHERE ' . $where
                );
            
            $result->execute($data);
            
            return $id;
        }
        
        public static function destroy($where)
        {
            $connection = static::getConnection();
            
            $result = $connection->prepare(
                    'DELETE FROM ' . static::$_table 
                    . ' WHERE ' . $where
                );
            
            $result->execute();
        }
        
        public static function avg($column, $where)
        {
            $result = static::getConnection()
                    ->prepare(
                        'SELECT AVG(' . $column . ') AS average FROM ' . static::$_table 
                        . ' WHERE ' . $where
                    );
            
            $result->execute();
            
            return static::convertToCollection($result->fetchAll(PDO::FETCH_ASSOC));
        }
        
        protected static function convertToCollection($array)
        {
            $collection = [];
            
            foreach ($array as $element)
            {
                $collection [] = static::convertToObject($element);
            }
            
            return $collection;
        }
        
        protected static function convertToObject($array)
        {
            $object = new stdClass();
            
            foreach ($array as $key => $value)
            {
                $object->$key = $value;
            }
            
            return $object;
        }
    }
