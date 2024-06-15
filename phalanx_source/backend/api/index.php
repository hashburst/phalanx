<?php

require_once '../business_logic/process_data.php';
require_once '../config/config.php';

header('Content-Type: application/json');

// Funzione per gestire le richieste HTTP
function handleRequest() {
    $method = $_SERVER['REQUEST_METHOD'];
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    switch ($method) {
        case 'GET':
            handleGet($path);
            break;
        case 'POST':
            handlePost($path);
            break;
        case 'PUT':
            handlePut($path);
            break;
        case 'DELETE':
            handleDelete($path);
            break;
        default:
            echo json_encode(['error' => 'Method not allowed']);
            http_response_code(405);
            break;
    }
}

// Gestione delle richieste GET
function handleGet($path) {
    // Esempio: /api/key
    if ($path == '/api/key') {
        require_once 'key_management.php';
        $keyManagement = new KeyManagement(CONFIG['vault_addr'], CONFIG['vault_token']);
        $key = $keyManagement->get_key(CONFIG['key_path']);
        echo json_encode(['key' => $key]);
    } else {
        echo json_encode(['error' => 'Not found']);
        http_response_code(404);
    }
}

// Gestione delle richieste POST
function handlePost($path) {
    // Esempio: /api/process
    if ($path == '/api/process') {
        $data = json_decode(file_get_contents('php://input'), true);
        $result = processData($data);
        echo json_encode($result);
    } else {
        echo json_encode(['error' => 'Not found']);
        http_response_code(404);
    }
}

// Gestione delle richieste PUT
function handlePut($path) {
    // Esempio: /api/key
    if ($path == '/api/key') {
        require_once 'key_management.php';
        $keyManagement = new KeyManagement(CONFIG['vault_addr'], CONFIG['vault_token']);
        $result = $keyManagement->rotate_key(CONFIG['key_path']);
        echo json_encode(['message' => $result]);
    } else {
        echo json_encode(['error' => 'Not found']);
        http_response_code(404);
    }
}

// Gestione delle richieste DELETE
function handleDelete($path) {
    echo json_encode(['error' => 'Not implemented']);
    http_response_code(501);
}

// Avvio della gestione delle richieste
handleRequest();
