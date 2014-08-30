<?php

class Recipe
{

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

    /**
     * Get all recipes.
     *
     * @return Recipe[]
     * @throws Exception
     */
    public function getRecipies() {
        $recipes = array();
        $recipesData = $this->jsonFileToArray('recipes.json');

        if(!$recipesData) {
            throw new Exception('No recipes found.');
        }

        if(!empty($recipesData)) {
            foreach($recipesData as $recipe) {
                $instance = new self();
                $instance->setRecipeName($recipe['name']);
                $instance->setIngredients($recipe['ingredients']);
                $recipes[] = $instance;
            }
        }

        return $recipes;
    }

    /**
     * Get recommended recipe for night
     *
     * @param FridgeItem[]
     */
    public function getRecommendationTonight(FridgeItem $item)
    {
        // make all the recipies
    }


    /**
     * Read JSON from file and coverts it into array
     *
     * @param string $filename
     * @return array|bool
     * @throws Exception
     */
    private function jsonFileToArray($filename='')
    {
        if(!file_exists($filename) || !is_readable($filename)) {
            return FALSE;
        }

        $data = array();
        if($json = json_decode(file_get_contents($filename), true)) {
            $data = $json;
        } else {
            $data = FALSE;
            throw new Exception("Unable to read JSON from a file");
        }

        return $data;
    }


} 