<?php

namespace Hcode;


class Model{ //beginning Model

  private $values = [];

	public function __call($name, $args) { //beginning call

		$method = substr($name, 0, 3);
		$fielName = substr($name, 3, strlen($name));

		switch ($method) { //beginning switch
			case "get":
				return $this->values[$fielName];
			  break;

			case "set":
			    $this->values[$fielName] = $args[0];	
			  break;
		}//end switch

	} //end call

	public function setData($data = array()) { //beginning setData

		foreach ($data as $key => $value) {
			$this->{"set".$key}($value);//ciação dinamica
		}

	} //end setData

	public function getValues(){ //beggining getValues

		return $this-> $values;
	} //end getValues 


}//end Model

?>