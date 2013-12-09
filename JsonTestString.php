<?php
//header('Content-Type: text/html; charset=utf-8');

    $ar=array('bla' => array('zeug' => 'zeug2'));

    $arr = array(array('amount' => array('value' => 18, 'date' => date("Y-m-d H:m:s"), 'categoryName' => 'Frisur', 'categoryId' => 13)),
    array('amount' => array('value' => 12, 'date' => date("Y-m-d H:m:s"), 'categoryName' => 'Haargel', 'categoryId' => 14)));


    echo '{"entries":'.json_encode($arr).'}';

    //echo json_encode($ar);

/*
    $Jng = '{"categories":
    [{"Id":"8","Category":"Bier"},
    {"Id":"6","Category":"Burger"},
    {"Id":"10","Category":"Butter"},
    {"Id":"1","Category":"Pide"},
    {"Id":"2","Category":"Pizza"},
    {"Id":"11","Category":"Schmalz"},
    {"Id":"4","Category":"Schokolade"},
    {"Id":"5","Category":"Thunfisch"},
    {"Id":"3","Category":"Toast"},
    {"Id":"7","Category":"Vodka"}]}';

   $JsonString = array('TestGruppe' => array(array('elementName' => 'pizza'), array('elementName' => 'bier'), array('elementName' => 'hummer')));
    echo '{"groups":'.json_encode($JsonString).'}';
*/
?>




