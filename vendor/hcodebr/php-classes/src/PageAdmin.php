<?php

namespace Hcode;

 class PageAdmin extends Page {
    
    //beginning
 	public function __construct($opts = array(), $tpl_dir = "/views/admin/"){ //Buscando Layout Administrativo
 
 			parent::__construct($opts, $tpl_dir); //chamando as funções da classe pai
 	}
 	//end

 } 


?>