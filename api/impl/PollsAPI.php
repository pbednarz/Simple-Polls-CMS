<?php

// Polls
function getPolls()
{
    try {
        echo json_encode(Database::getInstance()->getPolls());
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function getPoll($id)
{
    try {
        echo json_encode(Database::getInstance()->getPollById($id));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function deletePoll($id)
{
    try {
        echo json_encode(Database::getInstance()->deletePoll($id));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function addPoll()
{
    try {
        $request = Slim::getInstance()->request();
        $json = json_decode($request->getBody());
        $mapper = new JsonMapper();
        $poll = $mapper->map($json, new Poll());
        echo json_encode(Database::getInstance()->addPoll($poll));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function updatePoll()
{
    try {
        $request = Slim::getInstance()->request();
        $json = json_decode($request->getBody());
        $mapper = new JsonMapper();
        $poll = $mapper->map($json, new Poll());
        echo json_encode(Database::getInstance()->updatePoll($poll));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

?>