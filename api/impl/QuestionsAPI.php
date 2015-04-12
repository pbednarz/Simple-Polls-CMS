<?php
// Questions
function getQuestion($poll_id, $id)
{
    try {
        echo json_encode(Database::getInstance()->getQuestionById($poll_id, $id));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function deleteQuestion($id)
{
    try {
        echo json_encode(Database::getInstance()->deleteQuestion($id));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function addQuestion()
{
    try {
        $request = Slim::getInstance()->request();
        $json = json_decode($request->getBody());
        $mapper = new JsonMapper();
        $question = $mapper->map($json, new Question());
        echo json_encode(Database::getInstance()->addQuestion($question));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function updateQuestion($id)
{
    try {
        $request = Slim::getInstance()->request();
        $json = json_decode($request->getBody());
        $mapper = new JsonMapper();
        $question = $mapper->map($json, new Question());
        $question->setQuestionId($id);
        echo json_encode(Database::getInstance()->updateQuestion($question));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function getQuestionsForPoll($poll_id)
{
    try {
        echo json_encode(Database::getInstance()->getQuestionsForPoll($poll_id));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function getQuestions()
{
    try {
        echo json_encode(Database::getInstance()->getQuestions());
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}
?>