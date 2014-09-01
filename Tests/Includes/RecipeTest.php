<?php

require_once ('Includes/FridgeItem.php');
require_once ('Includes/Recipe.php');


class RecipeTest extends PHPUnit_Framework_TestCase
{

    /**
     * @expectedException Exception
     */
    public function testGetRecommendationTonight() {
        $recipe = new Recipe();

        // if no fridge items is passed to the function
        $recipes = $recipe->getRecommendationTonight(array());
        $this->assertEquals(0, count($recipes), 'Recommended recipes should be zero.');

        // if default fridge items is passed to the function
        //$this->assertEquals(1, count($recipes), 'At least one recommendation should be given.');
    }

}