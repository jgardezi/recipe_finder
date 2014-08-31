<?php

include 'Includes/FridgeItem.php';
include 'Includes/Recipe.php';

$fridgeItem = new FridgeItem();
//var_dump($fridgeItem->getFridgeItemsData());

$recipe = new Recipe();
$recommendedRecipe = $recipe->getRecommendationTonight($fridgeItem->getFridgeItemsData());

if(isset($recommendedRecipe['name'])) {
    echo "<h3>Recommended recipe for tonight</h3>";
    echo "<p>" . $recommendedRecipe['name']->getRecipeName() . "</p>";
} else {
    echo "<p>" . $recommendedRecipe['error'] . "</p>";
}
