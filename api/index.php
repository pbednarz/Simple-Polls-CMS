<?php
include 'model/Poll.class.php';
include 'model/Question.class.php';
require '../vendor/autoload.php';
require 'database/database.class.php';
$app = new \Slim\Slim();
//$app->get('/polls', 'getPolls');
//$app->get('/polls/:id', 'getPoll');
//$app->post('/add_poll', 'addPoll');
//$app->put('/polls/:id', 'updatePoll');
//$app->delete('/polls/:id', 'deletePoll');

$app->get('/polls/:id/questions/', 'getQuestions');
$app->get('/polls/', 'getPolls');
$app->run();
$db = Database::getInstance();

function getQuestions($id) {
    try {
        echo json_encode(Database::getInstance()->getQuestions($id));
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function getPolls() {
    try {
        echo json_encode(Database::getInstance()->getPolls());
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
?>