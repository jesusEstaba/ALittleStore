<?php


use PHPUnit\Framework\TestCase;
require __DIR__ . '/../app/useCase/ItemUseCase.php';

class ItemUseCaseTest extends TestCase
{
    protected $item;
    
    function setUp()
    {
        $this->item = new ItemUseCase(
            FakeItemRepository::class,
            FakeRateRepository::class,
            'session'
        );
    }
    
    function testGetItemsWithRate()
    {
        $expectedResult = [
            (object)["id"=>1, "rate"=>3, "is_rated"=>false],
            (object)["id"=>2, "rate"=>3, "is_rated"=>false],
            (object)["id"=>3, "rate"=>3, "is_rated"=>false],
        ];
        
        $this->assertEquals($expectedResult, $this->item->getItemsWithRate());
    }
    
    function testRateToItem()
    {
        $this->assertEquals(5, $this->item->rate('1', 5));
    }
}

class FakeItemRepository
{
    static function get()
    {
        return [
            (object)["id"=>1],
            (object)["id"=>2],
            (object)["id"=>3],
        ];
    }
}

class FakeRateRepository
{
    static $rate;
    
    static function avg()
    {
        return [
            (object)["average"=> static::$rate ? static::$rate : 3]
        ];
    }
    
    static function getWhere()
    {
        return [];
    }

    static function save($data)
    {
        static::$rate = $data['rate'];
    }
}