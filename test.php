<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Peter Wegrzynek
 * Date: 20.11.13
 * Time: 15:56
 * To change this template use File | Settings | File Templates.
 */

class test {

    public static function jsonTestMethod() {
        //echo "routing funktioniert schonmal";
        $arr = array('amount' => array('value' => -6, 'date' => date(DATE_RFC822), 'categoryName' => 'party', 'categoryId' => 4));
        $arr2 = array('amount' => array('value' => -3, 'date' => date(DATE_RFC822), 'categoryName' => 'Alkohol', 'categoryId' => 3));
        echo json_encode($arr);
        echo json_encode($arr2);
    }
}