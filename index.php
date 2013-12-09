<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Peter Wegrzynek
 * Date: 20.11.13
 * Time: 15:05
 * To change this template use File | Settings | File Templates.
 */

use Slim\Slim;

require 'Slim/Slim.php';

Slim::registerAutoloader();


$app = new \Slim\Slim();

$app->contentType('application/json; charset=utf-8');
$res = $app->response();

//$app->get('/storeNewCategory/:cat', 'storeCats');
$app->get('/showCategories', 'showCats');       //vorhandene Kategorien anzeigen
$app->get('/getJson', 'getJsonObject');     //Daten vom Handy einlesen
//$app->get('/test', 'jsonTest');

// für die Charts
$app->get('/getOverall/:from/:to', 'getOverall');
$app->get('/getCategories/:from/:to', 'getCategories');
$app->get('/getGroups/:from/:to', 'getGroups');
$app->get('/getOverallGroupByDate/:from/:to', 'getOverallGroupByDate2');
$app->get('/getCategoryGroupByDate/:category/:from/:to', 'getCategoryGroupByDate');
$app->post('/createGroup', 'createNewGroup');

$app->get('/getGroups', 'getGroups');
$app->get('/getGroup/:group/:from/:to', 'getGroup2');
$app->get('/getCategoriesToGroup/:group', 'getCats');
$app->get('/deleteGroup/:groupName', 'deleteGroup2');
$app->get('/deleteCategory/:categoryName', 'deleteCategory2');
$app->get('/createCategory/:categoryName/:amount/:date', 'createEntry2');



$app->run();

require_once 'controller.php';
function createEntry2($name, $amount, $date) {
    ChartManager::createEntry($name, $amount, $date);
}
function deleteCategory2($category) {
    ChartManager::deleteCategory($category);
}
function deleteGroup2($group) {
    ChartManager::deleteGroup($group);
}
//{"group":{"0":"Burger","1":"Butter","2":"Pide","groupName":"xcvb"}}
function getCats($group) {
    ChartManager::getCategoriesFromGroup($group);
}
function getGroups() {
    controller::getAllGroups();
}

function getGroup2($group, $from, $to) {
    ChartManager::getGroupByDateAndAmount($group, $from, $to);
}
function createNewGroup() {
    $result=\Slim\Slim::getInstance()->request()->getBody();
    $string = urldecode($result);
    $vars = array();
    parse_str($string, $vars);
    controller::createGroup($vars);
    //print_r($vars['group']['0']);
}
function getCategoryGroupByDate($category, $from, $to) {
    ChartManager::getCategoryGroupByDate($category, $from, $to);
}
function getOverallGroupByDate2($from, $to) {
    ChartManager::getOverallGroupByDate($from, $to);
}
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
// http://localhost/financeplan/finance-plan/index.php/getOverallGroupByDate/2013-11-19%2004:22:13/2013-11-30%2004:22:13
function getOverall($from, $to) {
    ChartManager::getOverall($from, $to);
}

function getCategories($from, $to) {

}

//function getGroups($from, $to) {

//}
