<?php
/**
 * Created by PhpStorm.
 * User: jgardezi
 * Date: 27/08/2014
 * Time: 8:52 AM
 */

class Recipe {

    // recipe name
    private $recipeName;

    // list of ingredients
    private $ingredients = array();

    /**
     * @param array $ingredients
     */
    public function setIngredients($ingredients)
    {
        $this->ingredients = $ingredients;
    }

    /**
     * @return array
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * @param mixed $recipeName
     */
    public function setRecipeName($recipeName)
    {
        $this->recipeName = $recipeName;
    }

    /**
     * @return mixed
     */
    public function getRecipeName()
    {
        return $this->recipeName;
    }

    public function setRecipies($json) {
        // initialize data from json file
    }


    public function getRecipies() {

    }

    public function getRecommendationTonight() {
        // make all the recipies
    }


} 