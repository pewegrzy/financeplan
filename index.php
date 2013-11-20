<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Peter Wegrzynek
 * Date: 20.11.13
 * Time: 15:05
 * To change this template use File | Settings | File Templates.
 */
require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();


$app = new \Slim\Slim();
$app->contentType('application/json; charset=utf-8');
$res = $app->response();

//$app->get('/store', 'showTeste');
$app->get('/store/:cat', 'storeCat');
$app->get('/bla/:stuff', function($stuff){
    echo "halo ". $stuff;
});

$app->run();

require_once 'storeItems.php';


function storeCat($cat) {
    storeItems::newCategory($cat);
}

function showTeste(){
    //var_dump('hey');
    storeItems::showTest();
}
