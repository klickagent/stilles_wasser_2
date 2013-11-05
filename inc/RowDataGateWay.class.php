<?php 

	class Post {
	
		private $attrs = [];
		private $attrValues = [];
		
		private $id = false;
		private $version = false;
		
		private $model = 'tbl_person';
		
		
		public function __construct($attrs=false,$model=false,$fields=false){
			global $db;
			if( $model ) $this->model = $model;
			
			if($fields === false ){
				$this->attrs = array('author','date','title','content');
			} else {
				$this->attrs = $fields;
			}
			//init values:
			foreach( $this->attrs as $key ) {
				$this->attrValues[$key] = '';
			}
			if( $attrs !== false ) {
				if( $attrs === true ) $attrs = array();
				self::create($attrs);
			}
		}
		
		
		
		public function create($attrs){
			self::update($attrs,false);
		}
		
		public function update($attrs,$id=true){
			if( $id === true ) $id = $this->id;
			foreach( $attrs as $key => $attr ){
				$this->attrValues[$key] = $attr;
			}
			self::save($this->id);
		}
		
		private function save($id=false){
			global $db;
			$executeVals = $this->attrValues;
			
			
			
			if( $id === false ) {
				$executeVals['_version'] = microtime(true);
				$this->version = $executeVals['_version'];
				
				$keys = $this->attrs;
				$keys_t = implode(',',$keys);
				$vals = array_values($this->attrs);
				$vals_t = implode(',:',$vals);
		
				$t = 'INSERT INTO '.$this->model.' ('.$keys_t.',_version)
				VALUES (:'.$vals_t.',:_version);';
				$stmt = $db->prepare($t);
			
				if(DEBUG_DB_QUERIES)echo $t.'<br/>';
				
			} else {
				$executeVals['_versionNEW'] = microtime(true);
				$executeVals['_version'] = $this->version;
				$this->version = $executeVals['_versionNEW'];
				
				$s = [];
				foreach ( $this->attrs as $key ) {
					$s[] = $key . ' = :'.$key;
				}
				//add version timestamp
				$s[] = '_version=:_versionNEW';
				
				$t = 'UPDATE '.$this->model.' SET '.implode(',',$s).' WHERE id=:id AND _version=:_version;';
				$stmt = $db->prepare($t);
				
				$executeVals['id'] = $this->id;
				
				
				if(DEBUG_DB_QUERIES)echo $t.'<br/>';
				
			}
			$stmt->execute( $executeVals );
			
			//print_r( $stmt->errorInfo() );
			if(DEBUG_DB_QUERIES){
				print_r($executeVals);
				echo '<br/>';
			}
			if( $id === false ){
				$this->id = $db->lastInsertId('id');
				if(DEBUG_DB_QUERIES) echo 'id: '. $this->id.'<br/>';
			}
			
			
			
			if( DEBUG_DB_QUERIES && $stmt->rowCount() === 0 )
				echo '<br/><span style="background: red">CONCURRENT ERROR -> data not saved to db</span><br/>';
		}
		
		
		public function delete(){
			global $db;
			$t = 'DELETE FROM '.$this->model.' WHERE id= :id';
			$stmt = $db->prepare($t);
			$executeVals = array( 'id' =>  $this->id );
			$stmt->execute( $executeVals );
			
			
			if(DEBUG_DB_QUERIES){
				echo $t.'<br/>';
				print_r($executeVals);
				echo '<br/>';
			}
			
			
			foreach( $this->attrs as $key => $attr ){
				unset($this->attrValues[$key]);
			}
			//how can i destory an object?!
		}
		
		
		
		public function findByID( $id ){
			global $db;
			$executeVals = array( 'id' =>  $id ) ;
			$t = 'SELECT * FROM '.$this->model.' WHERE id= :id';
			$stmt = $db->prepare($t);
			$stmt->execute( $executeVals );
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			if(DEBUG_DB_QUERIES){
				echo $t.'<br/>';
				print_r($executeVals);
				echo '<br/>';
			}
			
			//save attrs in class:
			foreach( $this->attrs as $attr ){
				$this->attrValues[$attr] = $data[0][$attr];
			}
			//save id:
			$this->id = $data[0]['id'];
			
			//echo '<br/>'.$data[0]['_version'].'<br/>';
			
			$this->version = $data[0]['_version'];
			
			//var_dump($data);
		}
		
		
		public function __get($get)
		{
	        if (in_array($get, $this->attrs)) {
	           return self::getAttr($get);
	        }
	
	        $trace = debug_backtrace();
	        trigger_error(
	            'Undefined property via __get(): ' . $name .
	            ' in ' . $trace[0]['file'] .
	            ' on line ' . $trace[0]['line'],
	            E_USER_NOTICE);
	        return null;
	    } 
		
		public function getID(){
			return $this->id;
		}
		
		public function getCreated(){
			return self::getAttr('created');
		}
		
		public function getTitle(){
			return self::getAttr('title');
		}
		
		public function getContent(){
			return self::getAttr('content');
		}
		
		private function getAttr($attr){
			global $db;
			$attr_sql = SQLite3::escapeString($attr);
			$executeVals = array(  'id' =>  $this->id ) ;
			$t = 'SELECT '.$attr_sql.' FROM '.$this->model.' WHERE id= :id';
			$stmt = $db->prepare($t);
			$stmt->execute( $executeVals );
			//echo $stmt->debugDumpParams();
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			if(DEBUG_DB_QUERIES){
				echo $t.'<br/>';
				print_r($executeVals);
				echo '<br/>';
			}
			
			
			return $data[0][$attr];
		}
		
	}


 ?>