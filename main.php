<?php
/**
 * Created by PhpStorm.
 * User: jgardezi
 * Date: 27/08/2014
 * Time: 9:00 AM
 */

include 'Includes/FridgeItems.php';
include 'Includes/Recipe.php';

$jsonInput = array(
    array(
        'name' => "grilled cheese on toast",
        'ingredients' => array(
            array(
                'item' => 'bread',
                'amount' => '2',
                'unit' => 'slices',
            ),
            array(
                'item' => 'cheese',
                'amount' => '2',
                'unit' => 'slices',
            )
        ),
    ),
    array(
        'name' => "salad sandwich",
        'ingredients' => array(
            array(
                'item' => 'bread',
                'amount' => '2',
                'unit' => 'slices',
            ),
            array(
                'item' => 'mixed salad',
                'amount' => '200',
                'unit' => 'grams',
            )
        ),
    )
);
$jsonInput = json_encode($jsonInput);
//var_dump($jsonInput);

$fridgeItem = new FridgeItems();
$fridgeItem->getFridgeItemsData();
