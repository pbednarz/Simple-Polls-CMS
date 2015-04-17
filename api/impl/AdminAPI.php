<?php
$app->get('/session', function () {
    $session = SessionHander::getInstance()->getSession();
    $response["uid"] = $session['uid'];
    $response["email"] = $session['email'];
    $response["username"] = $session['username'];
    echoResponse(200, $session);
});

$app->get('/logout', function () {
    $session = SessionHander::getInstance()->destroySession();
    $response["status"] = "info";
    $response["message"] = "Wylogowany pomyślnie.";
    echoResponse(200, $response);
});

$app->post('/login', function () use ($app) {
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('username', 'password'), $r);
    $response = array();
    $password = $r->password;
    $username = $r->username;
    $user = Database::getInstance()->getAdminByUsernameOrEmail($username);
    if ($user != NULL) {
        if (sha1($password) == $user->getPassword()) {
            $response['status'] = "success";
            $response['message'] = "Poprawnie zalogowany. Witaj $username !";
            $response['username'] = $user->getUsername();
            $response['uid'] = $user->getId();
            $response['email'] = $user->getEmail();
            $response['createdAt'] = $user->getCreateTime();
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['uid'] = $user->getId();
            $_SESSION['email'] = $user->getEmail();
            $_SESSION['username'] = $user->getUsername();
        } else {
            $response['status'] = "error";
            $response['message'] = 'Logowanie nie powiodło się. Niepoprawne dane.';
        }
    } else {
        $response['status'] = "error";
        $response['message'] = 'Taki użytkownik nie jest zarejestrowany.';
    }
    echoResponse(200, $response);
});
?>