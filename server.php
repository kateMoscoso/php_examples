<?php

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
        'titulo' => 'Harry Potter and the Philosopher\'s Stone',
        'id_author' => 1,
        'i_genero' =>1
    ],
    2=> [
        'titulo' => 'Harry Potter and the Chamber of Secrets',
        'id_author' => 1,
        'i_genero' =>1
    ]
    ];

    header('Content-Type: application/json');

switch(strtoupper($_SERVER['REQUEST_METHOD'])){
    case 'GET':
        echo json_encode($books);
    break;
    case 'POST':
    break;
    case 'DELETE':
    break;
    case 'PUT':
    break;
}