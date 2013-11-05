<?php 

	define('ROOT', __DIR__ );
	
	
	
	
	define('DB_HOST', '127.0.0.1');
	define('DB', 'loc_orm');
	define('DB_USER', 'loc_orm');
	define('DB_PW', '12341234');
	
	define('TABLE_NAME','tbl_blog');
	
	define('DEBUG_DB_QUERIES',true);
	
	$db = new PDO('mysql:host='.DB_HOST.';dbname='.DB,DB_USER,DB_PW);
	//$db = new PDO('mysql:host=localhost;dbname=loc_orm','loc_orm','12341234');
	
	date_default_timezone_set('Europe/Zurich');
	
 ?>