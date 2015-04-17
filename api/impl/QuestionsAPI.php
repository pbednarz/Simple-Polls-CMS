<?php
$app->get('/questions/:id', function ($id) {
    try {
        echo json_encode(Database::getInstance()->getQuestionById($id));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
});

function getQuestion($poll_id, $id)
{
    try {
        echo json_encode(Database::getInstance()->getQuestionById($poll_id, $id));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

$app->delete('/questions/:id', function ($id) {
    try {
        echo json_encode(Database::getInstance()->deleteQuestion($id));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
});

$app->post('/questions/', function () use ($app) {
    try {
        $request = $app->request();
        $json = json_decode($request->getBody());
        $mapper = new JsonMapper();
        $question = $mapper->map($json, new Question());
        echo json_encode(Database::getInstance()->addQuestion($question));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
});

$app->post('/polls/:pollId/questions/', function ($pollId) use ($app) {
    try {
        $request = $app->request();
        $json = json_decode($request->getBody());
        $mapper = new JsonMapper();
        $question = $mapper->map($json, new Question());
        $question->setPollId($pollId);
        echo json_encode(Database::getInstance()->addQuestion($question));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
});

$app->put('/questions/:id', function ($id) use ($app) {
    try {
        $request = $app->request();
        $json = json_decode($request->getBody());
        $mapper = new JsonMapper();
        $question = $mapper->map($json, new Question());
        $question->setQuestionId($id);
        echo json_encode(Database::getInstance()->updateQuestion($question));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
});

$app->get('/polls/:poll_id/questions/', function ($poll_id) {
    try {
        echo json_encode(Database::getInstance()->getQuestionsForPoll($poll_id));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
});

$app->get('/questions/', function () {
    try {
        echo json_encode(Database::getInstance()->getQuestions());
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
});
?>