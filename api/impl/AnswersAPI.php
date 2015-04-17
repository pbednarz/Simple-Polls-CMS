<?php

// $app->get('/polls/:poll_id/questions/:id', 'getQuestion');
// $app->post('/polls/:poll_id/questions/', 'addQuestion');
// $app->put('/polls/:poll_id/questions/:id', 'updateQuestion');
// $app->delete('/polls/:poll_id/questions/:id', 'deleteQuestion');

$app->get('/answers', function() {
    try {
        echo json_encode(Database::getInstance()->getAnswers());
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
});

$app->get('/polls/:poll_id/questions/:question_id/', function($pollId, $questionId)
{
    try {
        echo json_encode(Database::getInstance()->getAnswersForQuestion($questionId));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
});
?>