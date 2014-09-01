<?php


if($_POST) {

    include 'Includes/FridgeItem.php';
    include 'Includes/Recipe.php';

    $allowedExts = array("json", "csv");
    $temp_csv = explode(".", $_FILES["file_csv"]["name"]);
    $extension_csv = end($temp_csv);
    $temp_json = explode(".", $_FILES["file_json"]["name"]);
    $extension_json = end($temp_json);

    if((($_FILES["file_json"]["type"] == "application/json"
        || $_FILES["file_json"]["type"] == "text/csv"))
        && ($_FILES["file_json"]["size"] < 20000)
        && ($_FILES["file_csv"]["size"] < 20000)
        && in_array($extension_csv, $allowedExts)
        && in_array($extension_json, $allowedExts)) {
        if ($_FILES["file_json"]["error"] > 0) {
            echo "Error: " . $_FILES["file_json"]["error"] . "<br>";
        } elseif($_FILES["file_csv"]["error"] > 0){
            echo "Error: " . $_FILES["file_csv"]["error"] . "<br>";
        } else {
            try {
                $fridgeItem = new FridgeItem();
                $recipe = new Recipe();

                $fridgeItems = $fridgeItem->getFridgeItemsData($_FILES["file_csv"]["tmp_name"]);
                $allRecipes = $recipe->getRecipes($_FILES["file_json"]["tmp_name"]);
                $recommendedRecipe = $recipe->getRecommendationTonight($fridgeItems, $allRecipes);

                if(isset($recommendedRecipe['name'])) {
                    echo "<h3>Recommended recipe for tonight</h3>";
                    echo "<p>" . $recommendedRecipe['name']->getRecipeName() . "</p>";
                } else {
                    echo "<p>" . $recommendedRecipe['error'] . "</p>";
                }
            } catch (Exception $e) {
                echo "<p>{$e->getMessage()}</p>";
            }
        }
    } else {
        if(empty($_FILES["file_json"]['name'])) {
            echo "<p>Please upload Json file</p>";
        }
        if(empty($_FILES["file_csv"]['name'])) {
            echo "<p>Please upload CSV file</p>";
        }
    }
    exit();
}

?>

<html>
    <body>
        <form action="main.php" method="post" enctype="multipart/form-data">
            <label for="file_csv">Upload Fridge items CSV File:</label>
            <input type="file" name="file_csv" id="file_csv"><br>
            <label for="file_json">Upload JSON recipes File:</label>
            <input type="file" name="file_json" id="file_json"><br>
            <input type="submit" name="submit" value="Submit">
        </form>

    </body>
</html>