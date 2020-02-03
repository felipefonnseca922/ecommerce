<?php

namespace Hcode\Model;

use \Hcode\DB\Sql; //Chamando a classe Sql dentro do DB
use \Hcode\Model;  //Chama o Model class para o User class

 class User extends Model{ //beginning User

 	const SESSION = "User";

 	public static function login ($login, $password){ //beginning login

 		$sql = new Sql();

 		$results = $sql->select("SELECT * FROM tb_users WHERE deslogin = LOGIN", array (

 			"LOGIN"=>$login //login da function

 		));

 		if (count($results) === 0) {
 			throw new \Exception("Usuario inexistente ou Senha inválida"); //testando se existe um usuario	
 		}

 		$data = $results[0]; //variavel data recebe results na posição 0

 		if(password_verify($password, $data["despassword"]) === true) {

 			$user = new User(); //criano uma instancia dentro do User

 			$user->setData($data);

 			$_SESSION[User::SESSION] = $user->getValues();

 			return $user;

 		}else {
 			throw new \Exception("Usuario inexistente ou Senha inválida");
 		}

 	}//end Login

 	//beggining verifyLogio
 	public static function verifyLogin($inadmin = true){ //verificando se está logado na admin

	 if (
	    !isset($_SESSION[User::SESSION]) //se não for definida
	 	||
	 	!$_SESSION[User::SESSION] //Se estiver vazia ou perdeu o valor
	 	||  
	 	!(int)$_SESSION[User::SESSION] > 0 //verificar o id do usuario
 		||
 		(bool)$_SESSION[User::SESSION]["inadmin"] !== $inadmin
	 ) {
	    	
	 header("Location: /admin/login");
	  exit;
	}		
  } //end verifyLogio

  //beginning logout
  public function logout(){

  	$_SESSION[User::SESSION] = NULL;

  }//end logout

 }//end User

?> 