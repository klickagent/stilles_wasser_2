<?php 
	
	error_reporting(E_ALL);
	
	require( 'config.php' );
	require( ROOT . '/app/controller/_frontController.php' );
	require( ROOT . '/inc/request_http.class.php' );
	
	
	//require( ROOT . '/inc/initDB.php' );
	
	
	
	
	$request = new Request_http( );
	
	
	$frontController = new frontController( $request );

 ?>