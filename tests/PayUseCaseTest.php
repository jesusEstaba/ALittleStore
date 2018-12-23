<?php


use PHPUnit\Framework\TestCase;
require __DIR__ . '/../app/useCase/PayUseCase.php';

class PayUseCaseTest extends TestCase
{
    protected $pay;
    protected $cart;
    
    function setUp()
    {
        $this->cart = new FakeCart();
        
        $this->pay = new PayUseCase(
            FakeSellRepository::class,
            FakeSessionService::class,
            $this->cart
        );
    }
    
    function testSellWhenYouHaveSufficientFundsWithUps()
    {
        $this->cart->setTotal(10);
        
        $this->assertEquals(15, $this->pay->sell('ups'));
    }
    
    function testSellWhenYouDontHaveSufficientFundsWithUps()
    {
        $this->cart->setTotal(100);
        
        $this->assertEquals(0, $this->pay->sell('ups'));
    }
}

class FakeCart
{
    protected $_amount;
    
    function clear() {}
    
    function setTotal($amount)
    {
        $this->_amount = $amount;
    }
    
    function getTotal()
    {
        return $this->_amount;
    }
}

class FakeSellRepository
{
    static function save() {}
}

class FakeSessionService
{
    static function get($name)
    {
        $session = [
            "id" => 'session',
            "pocket" => 100
        ];
        
        return $session[$name];
    }
    
    static function set() {}
}