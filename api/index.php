<?php

foreach (glob("model/*.php") as $filename)
{
    include $filename;
}

foreach (glob("impl/*.php") as $filename)
{
    include $filename;
}

require '../vendor/autoload.php';
require 'database/database.class.php';
use \Slim\Middleware\HttpBasicAuthentication\AuthenticatorInterface;
use \Slim\Slim AS Slim;

class APIAuthenticator implements AuthenticatorInterface {
    public function authenticate($user, $pass) {
        return Database::getInstance()->authenticateAdminByUsernameAndPassword("admin", "admin");
    }
}

$app = new Slim();
$app->add(new \Slim\Middleware\HttpBasicAuthentication([
    "authenticator" => new APIAuthenticator()
]));

//USERS CRUD
$app->get('/users/', 'getUsers');
$app->get('/users/:id', 'getUser');
$app->post('/users/', 'addUser');
$app->delete('/users/:id', 'deleteUser');

//POLLS CRUD
$app->get('/polls/', 'getPolls');
$app->get('/polls/:id', 'getPoll');
$app->post('/polls/', 'addPoll');
$app->put('/polls/:id', 'updatePoll');
$app->delete('/polls/:id', 'deletePoll');

// POLLS/QUESTIONS CRUD
$app->get('/questions/', 'getQuestions');
$app->get('/questions/:id', 'getQuestion');
$app->post('/questions/', 'addQuestion');
$app->put('/questions/:id', 'updateQuestion');
$app->get('/polls/:poll_id/questions/', 'getQuestionsForPoll');


// POLLS/QUESTIONS/ANSWERS CRUD
$app->get('/polls/:poll_id/questions/:question_id/', 'getAnswersForQuestion');
// $app->get('/polls/:poll_id/questions/:id', 'getQuestion');
// $app->post('/polls/:poll_id/questions/', 'addQuestion');
// $app->put('/polls/:poll_id/questions/:id', 'updateQuestion');
// $app->delete('/polls/:poll_id/questions/:id', 'deleteQuestion');
$app->get('/answers', 'getAnswers');


$app->run();
?>