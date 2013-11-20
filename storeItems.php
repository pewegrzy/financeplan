<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Peter Wegrzynek
 * Date: 20.11.13
 * Time: 15:19
 * To change this template use File | Settings | File Templates.
 */

class storeItems {

    public static function newCategory($category) {
        $null = NULL;
        $sql = "INSERT INTO categories (
        Category
        ) VALUES (
        :category
        )";
        try{
            $db = dbConnect::getConnection();
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":category", $category);
            $stmt->execute();
            echo "update gut";
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public static function showTest() {
        echo "routing funktioniert schonmal";
    }
}