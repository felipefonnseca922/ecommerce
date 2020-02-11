<?php

namespace Hcode\Model;

use \Hcode\DB\Sql; //Chamando a classe Sql dentro do DB
use \Hcode\Model;  //Chama o Model class para o User class

 class User extends Model{ //beginning User

 	const SESSION = "User";
  const SECRET = "HcodePhp7_secret";

 	public static function login($login, $password){ //beginning login

 		$sql = new Sql();                                                
                                                                  //'$login'
 		$results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array (

 			":LOGIN"=>$login //login da function

 		));

 		if (count($results) === 0) {
 			throw new \Exception("Usuario inexistente ou Senha inválida!!"); //testando se existe um usuario	
 		}

 		$data = $results[0]; //variavel data recebe results na posição 0

 		if(password_verify($password, $data["despassword"]) === true) {

 			$user = new User(); //criano uma instancia dentro do User

 			$user->setData($data);

 			$_SESSION[User::SESSION] = $user->getValues();

 			return $user;

 		} else {
 			throw new \Exception("Usuario inexistente ou Senha inválida!!");
 		}

 	}//end Login

 	//beggining verifyLogio
 	public static function verifyLogin($inadmin = true){ //verificando se está logado na admin

	 if (
	  !isset($_SESSION[User::SESSION]) //se não for definida
	 	||
	 	!$_SESSION[User::SESSION] //Se estiver vazia ou perdeu o valor
	 	||  
	 	!(int)$_SESSION[User::SESSION]["iduser"] > 0 //verificar o id do usuario
 		||
 		(bool)$_SESSION[User::SESSION]["inadmin"] !== $inadmin 
	 ) {
	    	
	 header("Location: /admin/login");
	  exit;
	}		
  } //end verifyLogio

  //beginning logout
  public static function logout(){

  	$_SESSION[User::SESSION] = NULL;

  }//end logout

  public static function listAll(){//beginning ListAll

  	$sql = new Sql();

  	return $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) ORDER BY b.desperson");

  }//end listAll

  public function save(){ //beginning Save

      $sql = new Sql();

     $results = $sql->select("CALL sp_users_save(:desperson, :deslogin, :despassword, :desemail, :nrphone, :inadmin)", array(

        ":desperson"=>$this->getdesperson(),
        ":deslogin"=>$this->getdeslogin(),
        ":despassword"=>$this->getdespassword(),
        ":desemail"=>$this->getdesemail(),
        ":nrphone"=>$this->getnrphone(),
        ":inadmin"=>$this->getinadmin()
      ));

     $this->setData($results[0]);

  }//end Save

  public function get($iduser){ //beginning get

    $sql = new Sql();

    $results = $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) WHERE a.iduser = :iduser", array(":iduser"=>$iduser));

    $this->setData($results[0]);

  }//end get

  public function update() {//beginning update

    $sql = new Sql();

     $results = $sql->select("CALL sp_usersupdate_save(:piduser :pdesperson, :pdeslogin, :pdespassword, :pdesemail, :pnrphone, :pinadmin)", array(

        "piduser"=>$this->getiduser(),
        ":pdesperson"=>$this->getdesperson(),
        ":pdeslogin"=>$this->getdeslogin(),
        ":pdespassword"=>$this->getdespassword(),
        ":pdesemail"=>$this->getdesemail(),
        ":pnrphone"=>$this->getnrphone(),
        ":pinadmin"=>$this->inadmin()

      ));

     $this->setData($results[0]);


  }//end update

  public function delete() {//beginning delete

    $sql = new Sql();

    $sql->query("CALL sp_users_delete(:iduser)", array(

      "iduser"=>$this->getiduser()

    ));

  }//end delete

  public static function getForgot($email){ //beginning getForgot

    $sql = new Sql();

    $results = $sql->select("SELECT * FROM tb_persons  a INNER JOIN tb_users b USING(idperson) WHERE a.desemail = :email", array(
        ":email"=>$email
    ));

    if(count($results) === 0){
      throw new \Exception("Não foi possivel recuperar a senha.");
    } else {

      $data = $results[0];

      $results2 = $sql->select("CALL sp_userspasswordsrecoveries_create(:iduser, :desip)", array(
        ":iduser"=>$data["iduser"],
        ":desip"=>$_SERVER["REMOTE_ADDR"]
      ));

      if (count($results2) === 0) {
        throw new \Exception("Não foi possivel recuperar a senha.");
        
      } else {
        $dataRecovery = $results2[0];

        $code = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, User::SECRET, $dataRecovery["idrecovery"], MCRYPT_MODE_ECB)); 

        $link = "http://www.codecommerce.com.br/admin/forgot/reset?code=$code";

         $mailer = new Mailer($data["desemail"], $data["desperson"], "Redefinir senha", "forgot", array(

          "name"=>$data["desperson"],
          "link"=>$link
         ));

         $mailer->sent();

         return $data;
      }

    }

  }//end getForgot


}//end User

?> 