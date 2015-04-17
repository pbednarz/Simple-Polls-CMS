<?php
// Polls
$app->get('/polls/', function () {
    try {
        echo json_encode(Database::getInstance()->getPolls());
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
});

$app->get('/polls/:id', function ($id) {
    try {
        echo json_encode(Database::getInstance()->getPollById($id));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
});

$app->delete('/polls/:id', function ($id) {
    try {
        echo json_encode(Database::getInstance()->deletePoll($id));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
});

$app->post('/polls/', function () use ($app) {
    try {
        $request = $app->request();
        $json = json_decode($request->getBody());
        $mapper = new JsonMapper();
        $poll = $mapper->map($json, new Poll());
        echo json_encode(Database::getInstance()->addPoll($poll));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
});

$app->put('/polls/:id', function () use ($app) {
    try {
        $request = $app->request();
        $json = json_decode($request->getBody());
        $mapper = new JsonMapper();
        $poll = $mapper->map($json, new Poll());
        echo json_encode(Database::getInstance()->updatePoll($poll));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
});

?>