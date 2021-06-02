<?php

namespace User\Balance\Tests;

use User\Balance\Entity\User;
use User\Balance\Entity\Balance;
use PHPUnit\Framework\TestCase;

class BalanceTest extends TestCase {

    /**
     * @covers TotalBalance::getTotalBalance
     * @covers TotalBalance::increaseBalance
     * @covers TotalBalance::decreaseBalance
     * 
     */
    public function testTotalBalance() {
        $u = new User("user1", "user1@mail.com", "user1 address1");
        $tb = $u->getTotalBalance();
        //var_dump($tb);
        $this->assertEquals(0, $tb->getAmount());

        $tb->increaseBalance(200);
        $this->assertEquals(200, $tb->getAmount());

        //This statement sholdn't work, because we try to debit more than actual balance so it should be equeal 500
        $tb->decreaseBalance(730);
        $this->assertEquals(200, $tb->getAmount());

        //This statement should be equeal 150 (normal case, we debit allowed sum from balance)
        $tb->decreaseBalance(150);
        $this->assertEquals(50, $tb->getAmount());

        //This statement should be equeal 0 (attempt to debit more than balance value)
        $tb->decreaseBalance(50);
        $this->assertEquals(0, $tb->getAmount());

        //This statement should be equeal false
        $tb->decreaseBalance(1);
        $this->assertEquals(false, $tb->getAmount());
        
        $this->assertEquals(0, $tb->getAmount());
        
        $tb->increaseBalance(0.15);
        $this->assertEquals(0.15, $tb->getAmount());
    }

    /**
     * @covers User::getTotalBalance
     * @covers User::decreaseBalance
     */
    public function testExceedBalance() {
        $u = new User("user2", "user2@mail.com", "user2 address2 some street");
        //Try to debit more than balance value
        $tb = $u->getTotalBalance();
        $this->assertEquals(false, $tb->decreaseBalance(-1000));
    }

}
