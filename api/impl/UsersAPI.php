<?php
// Users
function getUsers()
{
    try {
        echo json_encode(Database::getInstance()->getUsers());
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function getUser($id)
{
    try {
        echo json_encode(Database::getInstance()->getUserByID($id));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function deleteUser($id)
{
    try {
        echo json_encode(Database::getInstance()->deleteUser($id));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function addUser()
{
    try {
        $request = Slim::getInstance()->request();
        $json = json_decode($request->getBody());
        $mapper = new JsonMapper();
        $user = $mapper->map($json, new User());
        echo json_encode(Database::getInstance()->addUser($user));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}
?>