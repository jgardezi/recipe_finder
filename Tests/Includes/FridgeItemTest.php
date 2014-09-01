<?php

require_once ('Includes/FridgeItem.php');
require_once ('Includes/Recipe.php');

class FridgeItemTest extends PHPUnit_Framework_TestCase
{

    /**
     * @expectedException Exception
     */
    public function testGetFridgeItemsData() {
        $fridgeItem = new FridgeItem();
        // test it with data file
        $this->assertTrue(count($fridgeItem->getFridgeItemsData()) > 0, 'Fridge items found.');

        // test it with empty file
    }

} 