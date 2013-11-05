<?php 
	require( ROOT . '/inc/RowDataGateWay.class.php' );
	require( ROOT . '/inc/TableDataGateWay.class.php' );


	class BlogModel{
		
		private $postTable;
		
		
		public function __construct() {
			$this->postTable = new PostTable( TABLE_NAME );
		}
		
		public function getAllPosts(){
			return $this->postTable->fetchAll();
		}
		
		public function getPostById( $id ){
			return $this->postTable->findPostBy('id',$id);
		}
		
		public function createPost( $postArray ){
			$post = new Post( false , TABLE_NAME );
			$post->create( $postArray );
		}
		
	
	}

 ?>