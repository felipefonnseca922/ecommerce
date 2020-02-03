<?php 
session_start();
require_once("vendor/autoload.php");

use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;

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

	User::verifyLogin();

    $page = new PageAdmin(); //esta chamando o construct
    $page->setTpl("index");


});
//end

//beginning
$app->get('/admin/login', function(){

	$page = new PageAdmin([
		"header" => false, //desabilitando do admin
		"footer" => false  //desabilitando do admin

	]); //esta chamando o login na pasta PageAdmin
	$page->setTpl("login");


});

$app->post('/admin/login', function() {

  User::login($_POST["login"], $_POST["password"]); //metodo estatico
  
  header("Location: /admin");
  exit;

});

$app->get('/login/logout', function(){ //exit function

 User::logout();

 header("Location: /admin/logout");
 exit;

});

$app->run();

 ?>