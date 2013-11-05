<?php

include( ROOT . '/inc/request.interface.php' );



class Request_http implements request{

	private function getAllParameters(){
		return explode('/' , $_GET['vars'] );
	}

	public function getController(){
		return self::getAllParameters()[0];
	}
	

	public function getView(){
		return self::getAllParameters()[1];
	}

	
	public function getAction(){
		return self::getAllParameters()[2];
	}
	
	
} 

 ?>