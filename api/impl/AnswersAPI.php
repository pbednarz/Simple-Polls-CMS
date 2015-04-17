<?php

// $app->get('/polls/:poll_id/questions/:id', 'getQuestion');
// $app->post('/polls/:poll_id/questions/', 'addQuestion');
// $app->put('/polls/:poll_id/questions/:id', 'updateQuestion');
// $app->delete('/polls/:poll_id/questions/:id', 'deleteQuestion');

$app->get('/answers', function () {
    try {
        echo json_encode(Database::getInstance()->getAnswers());
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
});

$app->get('/polls/:poll_id/questions/:question_id/', function ($pollId, $questionId) {
    try {
        echo json_encode(Database::getInstance()->getAnswersForQuestion($questionId));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
});

$app->post('/polls/:poll_id/questions/:question_id/', function ($pollId, $questionId) use ($app) {
    try {
        $request = $app->request();
        $json = json_decode($request->getBody());
        $mapper = new JsonMapper();
        $answer = $mapper->map($json, new Answer());
        $answer->setPollId($pollId);
        $answer->setQuestionId($questionId);
        echo json_encode(Database::getInstance()->addAnswer($answer));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
});

$app->post('/answers/', function () use ($app) {
    try {
        $request = $app->request();
        $json = json_decode($request->getBody());
        $mapper = new JsonMapper();
        $answer = $mapper->map($json, new Answer());
        echo json_encode(Database::getInstance()->addAnswer($answer));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
});

$app->put('/answers/:answer_id', function ($answer_id) use ($app) {
    try {
        $request = $app->request();
        $json = json_decode($request->getBody());
        $mapper = new JsonMapper();
        $answer = $mapper->map($json, new Answer());
        $answer->setAnswerId($answer_id);
        echo json_encode(Database::getInstance()->updateAnswer($answer));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
});

$app->delete('/answers/:answer_id', function ($answer_id) use ($app) {
    try {
        echo json_encode(Database::getInstance()->deleteAnswer($answer_id));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
});
?>