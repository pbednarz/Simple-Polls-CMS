<?php
include 'model/Poll.class.php';
include 'model/Question.class.php';
require '../vendor/autoload.php';
require 'database/database.class.php';
use \Slim\Slim AS Slim;

$app = new Slim();

//POLLS CRUD
$app->get('/polls/', 'getPolls');
$app->get('/polls/:id', 'getPoll');
$app->post('/polls/', 'addPoll');
$app->put('/polls/:id', 'updatePoll');
$app->delete('/polls/:id', 'deletePoll');

// POLLS/QUESTIONS CRUD
$app->get('/polls/:poll_id/questions/', 'getQuestions');
$app->get('/polls/:poll_id/questions/:id', 'getQuestion');
$app->post('/polls/:poll_id/questions/', 'addQuestion');
$app->put('/polls/:poll_id/questions/:id', 'updateQuestion');
$app->delete('/polls/:poll_id/questions/:id', 'deleteQuestion');

$app->run();
$db = Database::getInstance();

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

// Questions
function getQuestion($poll_id, $id)
{
    try {
        echo json_encode(Database::getInstance()->getQuestionById($poll_id, $id));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function deleteQuestion($poll_id, $id)
{
    try {
        echo json_encode(Database::getInstance()->deleteQuestion($poll_id, $id));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function addQuestion($poll_id)
{
    try {
        $request = Slim::getInstance()->request();
        $json = json_decode($request->getBody());
        $mapper = new JsonMapper();
        $question = $mapper->map($json, new Question());
        $question->setPollId($poll_id);
        echo json_encode(Database::getInstance()->addQuestion($question));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function updateQuestion($poll_id, $id)
{
    try {
        $request = Slim::getInstance()->request();
        $json = json_decode($request->getBody());
        $mapper = new JsonMapper();
        $question = $mapper->map($json, new Question());
        $question->setPollId($poll_id);
        $question->setQuestionId($id);
        echo json_encode(Database::getInstance()->updateQuestion($question));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function getQuestions($poll_id)
{
    try {
        echo json_encode(Database::getInstance()->getQuestions($poll_id));
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

?>