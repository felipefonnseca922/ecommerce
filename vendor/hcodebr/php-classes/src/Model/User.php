<?php

namespace Hcode\Model;

use \Hcode\DB\Sql; //Chamando a classe Sql dentro do DB
use \Hcode\Model;  //Chama o Model class para o User class

 class User extends Model{

 	//beginning login
 	public static function login ($login, $password){

 		$sql = new Sql();

 		$results = $sql->select("SELECT * FROM tb_users WHERE deslogin = LOGIN", array(

 			"LOGIN"=>$login //login da function

 		));

 		if (count($results) === 0) {
 			throw new \Exception("Usuario inexistente ou Senha inválida"); //testando se existe um usuario	
 		}

 		$data = $results[0]; //variavel data recebe results na posição 0

 		if(password_verify($password, $data["despassword"]) === true){

 			$user = new User(); //criano uma instancia dentro do User
 			$user->setData($data);

 		}else {
 			throw new \Exception("Usuario inexistente ou Senha inválida");
 		}

 	}//end Login

 }//end User








?>