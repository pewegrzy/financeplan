<?php
header('Content-Type: text/html; charset=utf-8');

    $ar=array('bla' => array('zeug' => 'zeug2'));

    $arr = array(array('amount' => array('value' => -6, 'date' => date("Y-m-d H:m:s"), 'categoryName' => 'party', 'categoryId' => 4)),
    array('amount' => array('value' => -3, 'date' => date("Y-m-d H:m:s"), 'categoryName' => 'Alkohol', 'categoryId' => 3)));


    echo '{"entries":'.json_encode($arr).'}';

    //echo json_encode($ar);


?>



