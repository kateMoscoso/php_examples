<?php
header( 'Content-Type: application/json' );

if ( 
	!array_key_exists('HTTP_X_HASH', $_SERVER) || 
	!array_key_exists('HTTP_X_TIMESTAMP', $_SERVER) || 
	!array_key_exists('HTTP_X_UID', $_SERVER)  
	) {
		header( 'Status-Code: 403' );
	
		echo json_encode(
			[
				'error' => "No authorized",
			]
		);
		
		die;
	}

list( $hash, $uid, $timestamp ) = [ $_SERVER['HTTP_X_HASH'], $_SERVER['HTTP_X_UID'], $_SERVER['HTTP_X_TIMESTAMP'] ];
$secret = 'Secret token';
$newHash = sha1($uid.$timestamp.$secret);

if ( $newHash !== $hash ) {
	header( 'Status-Code: 403' );
	
		echo json_encode(
			[
				'error' => "No authorized. Hash correct: $newHash, hash received: $hash",
			]
		);
		
		die;
}
$allowedResourcesTypes = [
    'books',
    'authors',
    'genres'
];

$resourceType = $_GET['resource_type'];

if(!in_array($resourceType,$allowedResourcesTypes )){
    die;
}

$books = [
    1=> [
        'title' => 'Harry Potter and the Philosopher\'s Stone',
        'id_author' => 1,
        'id_genre' =>1
    ],
    2=> [
        'title' => 'Harry Potter and the Chamber of Secrets',
        'id_author' => 1,
        'id_genre' =>1
    ]
];

header('Content-Type: application/json');
$resourceId = array_key_exists('resource_id', $_GET) ? $_GET['resource_id']:'';

switch(strtoupper($_SERVER['REQUEST_METHOD'])){
    case 'GET':
        if(empty($resourceId)){
        echo json_encode($books);
        }
        else {
            if( array_key_exists( $resourceId, $books) ){
                echo json_encode( $books[ $resourceId ] );
            }
        }
    break;
    case 'POST':
        $json = file_get_contents('php://input');
        $books[] = json_decode($json, true);
        echo array_keys($books)[count($books)-1];
    break;
    case 'DELETE':
        if(!empty($resourceId) && array_key_exists( $resourceId, $books) ){
            unset ($books[$resourceId]);
            echo json_encode($books);
        }
    break;
    case 'PUT':
        if(!empty($resourceId) && array_key_exists( $resourceId, $books) ){
            $json = file_get_contents('php://input');
            $books[$resourceId] = json_decode($json, true);
            echo json_encode($books);
        }
    break;
}