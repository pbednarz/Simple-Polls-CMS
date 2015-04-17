<?php
$app->post('/users/', function() use ($app) {
    try {
        echo json_encode(Database::getInstance()->getUsers());
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
});

$app->post('/users/:id', function($id) use ($app) {
    try {
        echo json_encode(Database::getInstance()->getUserByID($id));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
});

$app->delete('/users/:id', function($id) use ($app) {
    try {
        echo json_encode(Database::getInstance()->deleteUser($id));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
});

$app->post('/users/', function() use ($app) {
    try {
        $request = $app->request();
        $json = json_decode($request->getBody());
        $mapper = new JsonMapper();
        $user = $mapper->map($json, new User());
        echo json_encode(Database::getInstance()->addUser($user));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
});
?>