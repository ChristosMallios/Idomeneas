<?php

function checkArr(&$array, $key, $value = null){

	if(is_null($array) || !isset($array) || empty($array))
		return null;
		
	if(isset($array[$key]) && !empty($array[$key]))
	{
		if($value == null)
			return $array[$key];
		else 
			return $array[$key] == $value;
	}
	else
		return null;
}

function my_XSS_SECURE(&$item, $key){
		$item = htmlspecialchars($item, ENT_QUOTES, "UTF-8");
	}
	
?>