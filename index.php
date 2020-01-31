<?php 

require_once("vendor/autoload.php");

use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;

$app = new Slim();

$app->config('debug', true);

//beginning
$app->get('/', function() {

    $page = new Page(); //esta chamando o construct
    $page->setTpl("index");


});
//end

//beginning
$app->get('/admin', function() {

    $page = new PageAdmin(); //esta chamando o construct
    $page->setTpl("index");


});
//end

$app->run();

 ?>