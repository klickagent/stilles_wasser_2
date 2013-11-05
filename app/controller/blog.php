<?php 
	require( ROOT . '/app/model/blog.php' );
	
	
	class blogController{
		
		private $request;
		private $viewFile;
		
		public function __construct( $request ) {
		
		
			$this->request = $request;
			
			$this->viewFile = ROOT . '/app/view/'.$this->request->getView().'.php';
			
			if( ! is_file ( $this->viewFile ) ){
				die('<bold>view not found!</bold>');
			}
			
			
			$actionName = $this->request->getAction().'Action';
			if( ! method_exists( $this, $actionName )){
				$actionName = 'showAllAction';
				//die('<span style="color: red">Action not found!!</span>');
			}
			
			$this->{$actionName}();
			
		}
		
		public function showAction(){
			
			$this->renderView();
		}
		
		
		
		public function showAllAction(){
			$model = new BlogModel();
			$result = $model->getAllPosts();
			
			$this->renderView( $result );
		}
		
		
		public function renderView( $data ){
			
			
			
			//ob_start();
			include( $this->viewFile );
			//ob_flush();
			
			
		}
		
		
		
	
	}

 ?>