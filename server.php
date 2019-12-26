<?php
header( 'Content-Type: application/json' );

if ( !array_key_exists( 'HTTP_X_TOKEN', $_SERVER ) ) {

	die;
}

$url = 'https://'.$_SERVER['HTTP_HOST'].'/auth';

$ch = curl_init( $url );
curl_setopt( $ch, CURLOPT_HTTPHEADER, [
	"X-Token: {$_SERVER['HTTP_X_TOKEN']}",
]);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
$ret = curl_exec( $ch );

if ( curl_errno($ch) != 0 ) {
	die ( curl_error($ch) );
}

if ( $ret !== 'true' ) {
	http_response_code( 403 );

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