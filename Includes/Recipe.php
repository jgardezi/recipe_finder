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
     * Get current date time.
     *
     * @return DateTime
     */
    public function getCurrentDate() {
        return new DateTime('now');
    }

    /**
     * Get all recipes.
     *
     * @return Recipe[]
     * @throws Exception
     */
    public function getRecipes() {
        $recipes = FALSE;
        $recipesData = $this->jsonFileToArray('recipes.json');

        if(!$recipesData) {
            throw new Exception('No recipes found.');
        }

        if(!empty($recipesData)) {
            foreach($recipesData as $recipe) {
                if(!empty($recipe)) {
                    $instance = new self();
                    $instance->setRecipeName($recipe['name']);
                    $instance->setIngredients($recipe['ingredients']);
                    $recipes[] = $instance;
                }
            }
        }

        return $recipes;
    }

    /**
     * Get recommended recipe for night
     *
     * @param array $fridgeItems
     * @return bool
     * @throws Exception
     */
    public function getRecommendationTonight($fridgeItems = array())
    {
        $recRecipe = FALSE;
        $recipesFound = array();
        $matchedFridgeItems = array();
        $allRecipes = $this->getRecipes();

        if(empty($allRecipes)) {
            throw new Exception('No recipes found!');
        }

        // make all the recipies
        if(!empty($fridgeItems) || !empty($allRecipes)) {
            foreach($allRecipes as $recipe) {
                //find $recipe items in a fridge
                if($matchedFridgeItems = $this->findRecipeIngredients($fridgeItems, $recipe)) {
                    $recipesFound[] = array(
                        'name'  => $recipe,
                        'items' => $matchedFridgeItems,
                    );
                }
            }

            if(empty($recipesFound)) {
                $recRecipe['error'] = 'Order Takeout';
            } else {
                // assign the first found recipe
                $recRecipe = $recipesFound[0];
                // check if more than one recommended recipes found
                if(count($recipesFound) > 1) {
                    $recRecipeDateDiff = $recRecipe['items'];
                    foreach($recipesFound as $fRecipe) {
                        if($fRecipe['items']['smallestExpDate'] < $recRecipe['items']['smallestExpDate']) {
                            $recRecipe = $fRecipe;
                        }
                    }
                }
            }

        }

        return $recRecipe;
    }

    /**
     * Find recipe ingredients in the fridge base on
     *  items, amount availability and expiry date.
     *
     * @param array $fridgeItems
     * @param self
     * @return array Item found
     */
    private function findRecipeIngredients($fridgeItems, $recipe)
    {
        $itemsFound = FALSE;
        $matchedFridgeItem = array();
        $recipeItems = $recipe->getIngredients();

        if(!empty($recipeItems)) {
            $recpItemsExist = FALSE;
            foreach($recipeItems as $recipeItem) {
                foreach($fridgeItems as $fridgeItem) {
                    if($fridgeItem->getItemName() == $recipeItem['item']
                        && $fridgeItem->getUnit() == $recipeItem['unit']) {
                        // if recipe item is found, check the amount and expiry date
                        if($recipeItem['amount'] <= $fridgeItem->getAmount()
                            && $this->getCurrentDate() <= $fridgeItem->getExpiryDate()) {
                            $interval = $fridgeItem->getExpiryDate()->diff($this->getCurrentDate());
                            $matchedFridgeItem[] = array(
                                'fridgeItems' => $fridgeItem,
                                'dateDiffRecipeItem'    => $interval->d,
                            );
                            break;
                        }
                    }
                }
            }
            if(count($recipeItems) == count($matchedFridgeItem)) {
                $itemsFound = $matchedFridgeItem;
                $itemsFound['smallestExpDate'] = $matchedFridgeItem[0]['dateDiffRecipeItem'];
                foreach($matchedFridgeItem as $fItem) {
                    if($fItem['dateDiffRecipeItem'] <  $itemsFound['smallestExpDate']) {
                        $itemsFound['smallestExpDate'] = $fItem['dateDiffRecipeItem'];
                    }
                }
            }
        }

        return $itemsFound;
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