<?php


use PHPUnit\Framework\TestCase;
require __DIR__ . '/../app/useCase/CartUseCase.php';

class CartUseCaseTest extends TestCase
{
    protected $cart;
    
    function setUp()
    {
        $this->cart = new CartUseCase(
            CartRepository::class,
            ItemRepository::class,
            'session'
        );
    }
    
    function testIntance()
    {
        $this->assertInstanceOf(CartUseCase::class, $this->cart);
    }
    
    function testGetSlots()
    {
        $expectedResult = [
            (object)[
                "item_id"=>1,
                "quantity"=>1,
                "item"=> (object)[
                    "name"=>"product 1", 
                    "price"=>1
                ] 
            ],
            (object)[
                "item_id"=>2,
                "quantity"=>2,
                "item"=> (object)[
                    "name"=>"product 2", 
                    "price"=>2
                ] 
            ],
            (object)[
                "item_id"=>3,
                "quantity"=>3,
                "item"=> (object)[
                    "name"=>"product 3", 
                    "price"=>3
                ] 
            ]
        ];
        
        $this->assertEquals(
            $expectedResult, 
            $this->cart->getSlots()
        );
    }
    
    function testGetTotal()
    {
        $this->assertEquals(
            14, 
            $this->cart->getTotal()
        );
    }
    
    function testAddNewItem()
    {
        $this->cart->addItem('4', 4);
        
        $expectedResult = [
            (object)[
                "item_id"=>1,
                "quantity"=>1,
                "item"=> (object)[
                    "name"=>"product 1", 
                    "price"=>1
                ] 
            ],
            (object)[
                "item_id"=>2,
                "quantity"=>2,
                "item"=> (object)[
                    "name"=>"product 2", 
                    "price"=>2
                ] 
            ],
            (object)[
                "item_id"=>3,
                "quantity"=>3,
                "item"=> (object)[
                    "name"=>"product 3", 
                    "price"=>3
                ] 
            ],
            (object)[
                "item_id"=>4,
                "quantity"=>4,
                "item"=> (object)[
                    "name"=>"product 4", 
                    "price"=>4
                ] 
            ]
        ];
        
        $this->assertEquals($expectedResult, $this->cart->getSlots());
    }
    
    function testAddQuantityToItemSlot()
    {
        $this->cart->addItem('1', 2);
        
        $expectedResult = [
            (object)[
                "item_id"=>1,
                "quantity"=>3,
                "item"=> (object)[
                    "name"=>"product 1", 
                    "price"=>1
                ] 
            ],
            (object)[
                "item_id"=>2,
                "quantity"=>2,
                "item"=> (object)[
                    "name"=>"product 2", 
                    "price"=>2
                ] 
            ],
            (object)[
                "item_id"=>3,
                "quantity"=>3,
                "item"=> (object)[
                    "name"=>"product 3", 
                    "price"=>3
                ] 
            ]
        ];
        
        $this->assertEquals($expectedResult, $this->cart->getSlots());
    }
    
    function testClear()
    {
        $this->cart->clear();
        
        $this->assertEquals(
            [], 
            $this->cart->getSlots()
        );
    }
}

class CartRepository 
{
    public static $_empty = false;
    public static $_added = false;
    public static $_updated = false;
    
    static function getWhere($where)
    {
        
        if (isset($where['item_id'])) {
            $item_id = $where['item_id'];
            
            if ($item_id <= 3) {
                return [(object)["item_id"=>$item_id,"quantity"=>$item_id]];
            }
            
            return [];
        }
        
        if (static::$_empty) {
            return [];
        }
        
        if (static::$_updated) {
            return [
                (object)["item_id"=>1,"quantity"=>3],
                (object)["item_id"=>2,"quantity"=>2],
                (object)["item_id"=>3,"quantity"=>3],
            ];
        }
        
        if (static::$_added) {
            return [
                (object)["item_id"=>1,"quantity"=>1],
                (object)["item_id"=>2,"quantity"=>2],
                (object)["item_id"=>3,"quantity"=>3],
                (object)["item_id"=>4,"quantity"=>4],
            ];
        }
        
        return [
            (object)["item_id"=>1,"quantity"=>1],
            (object)["item_id"=>2,"quantity"=>2],
            (object)["item_id"=>3,"quantity"=>3],
        ];
    }
    
    static function update()
    {
        static::$_updated = true;
    }
    
    static function save()
    {
        static::$_added = true;
    }
    
    static function destroy()
    {
        static::$_empty = true;
    }
}

class ItemRepository 
{
    static function getById($id) 
    {
        return (object)["name"=>"product " . $id, "price"=>$id];
    }
}