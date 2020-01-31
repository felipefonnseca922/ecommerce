<?php

namespace Hcode;

use Rain\Tpl;

class Page {

private $tpl;
private $options = [];
private $defaults = [
  "data"=>[]
];

 //beginning
 public function __construct($opts = array()){
   //CONFIGURAÇÃO INICIAL DA PAGINA
  $this->options = array_merge($this->defaults, $opts);
 
  $config = array(
	    "tpl_dir"       => $_SERVER["DOCUMENT_ROOT"]. "/views/", 
		"cache_dir"     => $_SERVER["DOCUMENT_ROOT"]. "/views-cache/", 
		"debug"         => false 
	);

	Tpl::configure( $config );

    //ONDE ESTÁ INSTANCIADO
	$this->tpl = new Tpl;

	$this->setData($this->options["data"]);

	$this->tpl->draw("header");

 }
 //end

//beginning
   private function setData($data = array()){

   	 foreach ($this->options["data"] as $key => $value) {
		$this->tpl->assing($key, $value);

	}

}
//fim

//beginning
 public function setTpl($nome, $data = array(), $returnHTML = false){
      
       $this->setData($data);
       return $this->tpl->draw($nome, $returnHTML);
 }
//end

//beginning
 public function __destruct(){

 	$this->tpl->draw("footer");

 }

}
//end


?>