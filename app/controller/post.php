<?php 

	class postController{
		
		private $request;
		public function __construct( $request ) {
		
		
			$this->request = $request;
			
			$viewFile = ROOT . '/app/view/'.$this->request->getView().'.php';
		
			if( ! is_file ( $viewFile ) ){
				die('<bold>view not found!</bold>');
			}
			
			
			$actionName = $this->request->getAction().'Action';
			if( ! method_exists( $this, $actionName )){
				die('<span style="color: red">Action not found!!</span>');
			}
			
			
			$this->{$actionName}();
			
			
			
		}
		
		public function showAction(){
			
		}
		
		
		
		public function renderView(){
			
			//ob_start();
			include( $viewFile );
			//ob_flush();
			
			
		}
		
		
		
	
	}

 ?>