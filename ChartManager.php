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
}