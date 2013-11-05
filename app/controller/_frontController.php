<?php 

class frontController{
	
	public function __construct( $request ){
		
		/*echo $request->getController();
		echo $request->getView();
		echo $request->getAction();
		*/
		
		$controllerFile = ROOT . '/app/controller/'.$request->getController().'.php';
		if( !is_file( $controllerFile ) ){
			die('Controller not found');
		}
		include( $controllerFile );
		
		
		$controllerName = $request->getController().'Controller';
		$controller = new $controllerName( $request );
		
		
		
	}
	
}

 ?>