<?php
//Diese Klasse ist nur eine Testdatei und ist nicht in das Programm eingebunden

    $ar=array('bla' => array('zeug' => 'zeug2'));

    $arr = array(array('amount' => array('value' => 18, 'date' => date("Y-m-d H:m:s"), 'categoryName' => 'Frisur', 'categoryId' => 13)),
    array('amount' => array('value' => 12, 'date' => date("Y-m-d H:m:s"), 'categoryName' => 'Haargel', 'categoryId' => 14)));


    echo '{"entries":'.json_encode($arr).'}';

?>




