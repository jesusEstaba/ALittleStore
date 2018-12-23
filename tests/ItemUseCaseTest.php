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
    static function avg()
    {
        return [
            (object)["average"=>3]
        ];
    }
    
    static function getWhere()
    {
        return [];
    }
}