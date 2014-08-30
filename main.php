<?php

include 'Includes/FridgeItem.php';
include 'Includes/Recipe.php';

$fridgeItem = new FridgeItem();
//var_dump($fridgeItem->getFridgeItemsData());

$recipe = new Recipe();
var_dump($recipe->getRecipies());