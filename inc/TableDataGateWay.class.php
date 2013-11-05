<?php 

	class PostTable {
	
		private $posts = [];
		private $post_attrs = [];
		private $model = 'tbl_person';
		private $posts_data = [];
		
		public function __construct($model=false){
			if($model)$this->model = $model;
		}
		
		public function createPost($attrs=true,$model=false){
			if( $model ) $this->model = $model;
			$newPost = new Post($attrs);
			return $newPost;
		}
		
		public function updatePost($id,$attr){
			$editPost = new Post();
			$editPost->findByID($id);
			$editPost->update($attr);
			return $editPost;
		}
		
		public function deletePost($id){
			$deletePost = new Post();
			$deletePost->findByID($id);
			$deletePost->delete();
		}
		
		public function findPostBy($attr,$val=false){
			global $db;
			if( $attr === 'id' ) {
				$post = new Post();
				$post->findByID($val);
				return array($post);
			} else {
				//$attr kann array oder string sein!
				if( is_array($attr)){
					$executeVals = $attr;
					
					$where = [];
					foreach( $executeVals as $key => $val ){
						$attr_sql = SQLite3::escapeString($key);
						$where[] = $attr_sql.' =:'.$key;
					}
					$where = implode(' AND ', $where);
				} else {
					$attr_sql = SQLite3::escapeString($attr);
					$executeVals = array(  'val' =>  $val ) ;
					$where = $attr_sql.'=:val';
				}
			
				
				
				$t = 'SELECT * FROM '.$this->model.' WHERE '.$where;
				$stmt = $db->prepare($t);
				$stmt->execute( $executeVals );
				//echo $stmt->debugDumpParams();
				$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$this->posts_data = $data;
				
				if(DEBUG_DB_QUERIES){
					echo $t.'<br/>';
					print_r($executeVals);
					echo '<br/>';
				}
				$posts = [];
				foreach( $data as $obj ){
					$post = new Post();
					$post->findByID( $obj['id'] );
					$posts[] = $post;
				}
				$this->posts = $posts;
				return $posts;
			}
			
				
		}
		
		public function fetchAll(){
			global $db;
			$t = 'SELECT * FROM '.$this->model;
			$stmt = $db->prepare($t);
			$stmt->execute();
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$this->posts_data = $data;
			return $this->posts_data;
		}
		
		
	}


 ?>