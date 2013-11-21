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

$app->get('/storeNewCategory/:cat', 'storeCats');
$app->get('/showCategories', 'showCats');
$app->get('/getJson', 'getJsonObject');
$app->get('/test', 'jsonTest');


$app->run();

require_once 'controller.php';

function getJsonObject(){
    controller::getNewItemsFromJSON();
}

function storeCats($cat) {
    controller::createCategory($cat);
}

function showCats() {
    //echo "showCats";
    controller::showCategories();
}

function jsonTest(){
    test::jsonTestMethod();
}
