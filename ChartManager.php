<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Peter Wegrzynek
 * Date: 21.11.13
 * Time: 16:12
 * To change this template use File | Settings | File Templates.
 */

class ChartManager {

    public static function getOverall($from, $to){
        $sql = "SELECT * FROM entry AS e, categories AS c WHERE datum BETWEEN '".$from."' AND '".$to."' AND
                e.category_id = c.Id";
        try{
            $dbh = dbConnect::getConnection();
            $stmt = $dbh->query($sql);
            $msg = $stmt->fetchAll(PDO::FETCH_OBJ);
            $dbh = null;
            echo '{"entries":'.json_encode($msg).'}';

        } catch(PDOException $e) {
            echo $e;
        }
    }


    public static function getOverallGroupByDate($from, $to) {
        $sql = "SELECT date_format(e.datum, '%Y-%m-%d') AS tag, SUM(amount) AS ausgaben
                FROM entry AS e, categories AS c
                WHERE datum BETWEEN '".$from."' AND '".$to."'
                AND e.category_id = c.Id
                GROUP BY tag";
        try{
            $dbh = dbConnect::getConnection();
            $stmt = $dbh->query($sql);
            $msg = $stmt->fetchAll(PDO::FETCH_OBJ);
            $dbh = null;
            echo '{"entries":'.json_encode($msg).'}';

        } catch(PDOException $e) {
            echo $e;
        }
    }

    public static function getCategoryGroupByDate($category, $from, $to) {
        $sql = "SELECT date_format(e.datum, '%Y-%m-%d') AS tag, c.Category, SUM(e.amount) AS amount
                FROM entry AS e, categories AS c
                WHERE datum BETWEEN '".$from."' AND '".$to."'
                AND e.category_id = c.Id AND c.Category = '".$category."'
                GROUP BY tag";
        try{
            $dbh = dbConnect::getConnection();
            $stmt = $dbh->query($sql);
            $msg = $stmt->fetchAll(PDO::FETCH_OBJ);
            $dbh = null;
            echo '{"entries":'.json_encode($msg).'}';

        } catch(PDOException $e) {
            echo $e;
        }
    }

    public static function getGroupByDateAndAmount($group, $from, $to) {
        $sql = "SELECT date_format(e.datum, '%Y-%m-%d') AS tag,
                g.groupname, SUM(e.amount)  AS ausgaben
                FROM entry AS e, categories AS c,  categorygroup AS g
                WHERE e.datum BETWEEN '".$from."' AND '".$to."'
                AND g.groupname = '".$group."' AND g.category_id=c.Id AND e.category_id = c.Id GROUP BY tag";
        try{
            $dbh = dbConnect::getConnection();
            $stmt = $dbh->query($sql);
            $msg = $stmt->fetchAll(PDO::FETCH_OBJ);
            $dbh = null;

            echo '{"entries":'.json_encode($msg).'}';

        } catch(PDOException $e) {
            echo $e;
        }
    }

    public static function getCategoriesFromGroup($group) {
        $sql = "SELECT categoryname
                FROM categorygroup
                WHERE groupname = '".$group."'";
        try{
            $dbh = dbConnect::getConnection();
            $stmt = $dbh->query($sql);
            $msg = $stmt->fetchAll(PDO::FETCH_OBJ);
            $dbh = null;

            echo '{"entries":'.json_encode($msg).'}';

        } catch(PDOException $e) {
            echo $e;
        }
    }

    public static function deleteGroup($group) {
        $sql = "DELETE FROM categorygroup WHERE groupname='".$group."'";
        try
        {
            $db = dbConnect::getConnection();
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $db = null;
            echo "delete successful!";

        }
        catch(PDOException $e)
        {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public static function deleteCategory($category) {
        $catId = controller::getIdFromCategoryName($category);
        $sql = "DELETE FROM entry WHERE category_id='".$catId."'";
        try
        {
            $db = dbConnect::getConnection();
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $db = null;
            echo "delete successful!";

        }
        catch(PDOException $e)
        {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }

        $sql = "DELETE FROM categorygroup WHERE categoryname='".$category."'";
        try
        {
            $db = dbConnect::getConnection();
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $db = null;
            echo "delete successful!";

        }
        catch(PDOException $e)
        {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }

        $sql = "DELETE FROM categories WHERE Category='".$category."'";
        try
        {
            $db = dbConnect::getConnection();
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $db = null;
            echo "delete successful!";

        }
        catch(PDOException $e)
        {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }
    //entrys rausholen und amount hinzuaddieren

    public static function createEntry($category, $amount, $datum) {
        $user_id = 0;
        if(!controller::isCategoryExistend($category)) {
            controller::createCategory($category);
        }
        $categoryId = controller::getIdFromCategoryName($category);
        $sql = "INSERT INTO entry (
                    category_id,
                    amount,
                    datum,
                    user_id
                    ) VALUES (
                    :categoryId,
                    :amount,
                    :datum,
                    :userId
                    )";
        try{
            $db = dbConnect::getConnection();
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":categoryId", $categoryId);
            $stmt->bindParam(":amount", $amount);
            $stmt->bindParam(":datum", $datum);
            $stmt->bindParam(":userId", $user_id);
            $stmt->execute();
            echo "update gut";
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

}
/*
http://localhost/financeplan/finance-plan/index.php/getOverall/2013-11-19%2000:00:00/2013-11-30%2000:00:00

SELECT *
FROM `entry` AS `e`, `categories` AS `c`
WHERE `datum` BETWEEN '2013-11-19 00:00:00' AND '2013-11-30 00:00:00'
AND `e`.`category_id` = `c`.`Id`

SELECT date_format(`e`.`datum`, '%Y-%m-%d') AS `tag`, SUM(`amount`)
FROM `entry` AS `e`, `categories` AS `c`
WHERE `datum` BETWEEN '2013-11-19 00:00:00' AND '2013-11-30 00:00:00'
AND `e`.`category_id` = `c`.`Id`
GROUP BY `tag`

SELECT date_format(`e`.`datum`, '%Y-%m-%d') AS `tag`, `c`.`Category`, `e`.`amount`
FROM `entry` AS `e`, `categories` AS `c`
WHERE `e`.`datum` BETWEEN '2013-11-19 00:00:00' AND '2013-11-30 00:00:00'
AND `e`.`category_id` = `c`.`Id` AND `c`.`Category` = 'Pizza'
GROUP BY `tag`

gibt an wieviel geld ich pro kategorie ausgegeben habe

SELECT date_format(`e`.`datum`, '%Y-%m-%d') AS `tag`,
`g`.`groupname`, SUM(`e`.`amount`)  AS `bla`
FROM `entry` AS `e`, `categories` AS `c`,  `categorygroup` AS `g`
WHERE `e`.`datum` BETWEEN '2013-11-19 00:00:00' AND '2013-11-30 00:00:00'
AND `g`.`groupname` = 'Essen' AND `g`.`category_id`= `c`.`Id` AND `e`.`category_id` = `c`.`Id` group  by `tag`

group by `tag`, c.Category

INSERT INTO  `categorygroup`  ( `groupname` , `categoryname`, `category_id`)
SELECT * FROM (SELECT 'Essen', 'Burger2', '2') AS tmp
WHERE NOT EXISTS (
    SELECT `groupname` , `categoryname` FROM `categorygroup` WHERE `groupname` = 'Essen' AND `categoryname` = Burger2
) LIMIT 1;
*/