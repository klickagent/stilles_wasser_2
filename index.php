<?php 
	
	require( 'config.php' );
	require( ROOT . '/app/controller/_frontController.php' );
	require( ROOT . '/inc/request_http.class.php' );
	
	$request = new Request_http( );
	
	
	$frontController = new frontController( $request );

 ?>