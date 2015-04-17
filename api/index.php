<?php
require_once '../vendor/autoload.php';
require_once 'database/database.class.php';
require_once './SessionHandler.class.php';
use \Slim\Middleware\HttpBasicAuthentication\AuthenticatorInterface;
use \Slim\Slim AS Slim;

foreach (glob("model/*.php") as $filename)
{
    include_once $filename;
}

class APIAuthenticator implements AuthenticatorInterface {
    public function authenticate($user, $pass) {
        return Database::getInstance()->authenticateAdminByUsernameOrEmailAndPassword("admin", "admin");
    }
}

$app = new Slim();
foreach (glob("impl/*.php") as $filename)
{
    require_once $filename;
}

$app->add(new \Slim\Middleware\HttpBasicAuthentication([
    "authenticator" => new APIAuthenticator()
]));

function verifyRequiredParams($required_fields,$request_params) {
    $error = false;
    $error_fields = "";
    foreach ($required_fields as $field) {
        if (!isset($request_params->$field) || strlen(trim($request_params->$field)) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }

    if ($error) {
        $response = array();
        $app = \Slim\Slim::getInstance();
        $response["status"] = "error";
        $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        echoResponse(200, $response);
        $app->stop();
    }
}

function echoResponse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);

    // setting response content type to json
    $app->contentType('application/json');

    echo json_encode($response);
}
$app->run();
?>