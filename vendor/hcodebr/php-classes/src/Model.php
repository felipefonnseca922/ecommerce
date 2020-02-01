<?php

namespace Hcode;


class Model{ //beginning Model

  private $values = [];

	public function __call($name, $args) {

		$method = substr($name, 0, 3);
		$fielName = substr($name, 3, strlen($name));

		switch ($method) {
			case "get":
				return $this->values[$fielName];
			  break;
			case "set":
			    $this->values[$fielName] = $args[0];	
			  break;
		}

	}


}//end Model

?>