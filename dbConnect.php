<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Peter Wegrzynek
 * Date: 20.11.13
 * Time: 14:53
 * To change this template use File | Settings | File Templates.
 */

require_once('config.php');

class dbConnect {

    public static function getConnection() {
        $dbhost=config::$dbhost;
        $dbuser=config::$dbuser;
        $dbpass=config::$dbpass;
        $dbname=config::$dbname;
        try{
            $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $dbh->exec("set names utf8");
            return $dbh;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }
}