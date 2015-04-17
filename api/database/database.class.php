<?php

Class Database
{

    private static $db;
    private static $oInstance = false;

    public static function getInstance()
    {
        if (!self::$db) {
            self::$db = new PDO('mysql:host=localhost;dbname=polls;charset=utf8', 'root', '');
            self::$oInstance = new Database();
        }
        return self::$oInstance;
    }

    /** @var Admin $admin */
    public static function addAdmin($admin)
    {
        $stmt = self::$db->prepare("INSERT INTO admin(username, password, email) "
            . "VALUES(:username,:password,:email)");
        $stmt->execute(array(
                ':username' => $admin->getUsername(),
                ':password' => sha1($admin->getPassword()),
                ':email' => $admin->getEmail())
        );
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1) {
            return TRUE;
        }
        return FALSE;
    }

    public static function getAdmins()
    {
        $stmt = self::$db->query('SELECT * FROM admin');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** @var int $id */
    public static function getAdminByID($id)
    {
        $stmt = self::$db->prepare('SELECT * FROM admin WHERE adminId=?');
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = $results[0];
            $admin = new Admin();
            $admin->setId($result['adminId']);
            $admin->setUsername($result['username']);
            $admin->setPassword($result['password']);
            $admin->setEmail($result['email']);
            $admin->setCreateTime($result['createTime']);
            return $admin;
        }
    }

    public static function getAdminByUsernameAndPassword($username, $password)
    {
        $stmt = self::$db->prepare('SELECT * FROM admin WHERE username=? and password=?');
        $stmt->execute(array($username, sha1($password)));
        if ($stmt->rowCount() > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = $results[0];
            $admin = new Admin();
            $admin->setId($result['adminId']);
            $admin->setUsername($result['username']);
            $admin->setPassword($result['password']);
            $admin->setEmail($result['email']);
            $admin->setCreateTime($result['createTime']);
            return $admin;
        }
    }

    public static function authenticateAdminByUsernameOrEmailAndPassword($username, $password)
    {
        $stmt = self::$db->prepare('SELECT * FROM admin WHERE (username=? or email=?) and password=?');
        $stmt->execute(array($username, $username, sha1($password)));
        if ($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }

    public static function getAdminByUsernameOrEmail($username)
    {
        $stmt = self::$db->prepare('SELECT * FROM admin WHERE username=? OR email=?');
        $stmt->execute(array($username, $username));
        if ($stmt->rowCount() > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = $results[0];
            $admin = new Admin();
            $admin->setId($result['adminId']);
            $admin->setUsername($result['username']);
            $admin->setPassword($result['password']);
            $admin->setEmail($result['email']);
            $admin->setCreateTime($result['createTime']);
            return $admin;
        }
    }

    public static function getAdminByEmail($email)
    {
        $stmt = self::$db->prepare('SELECT * FROM admin WHERE email=?');
        $stmt->execute(array($email));
        if ($stmt->rowCount() > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = $results[0];
            $admin = new Admin();
            $admin->setId($result['adminId']);
            $admin->setUsername($result['username']);
            $admin->setPassword($result['password']);
            $admin->setEmail($result['email']);
            $admin->setCreateTime($result['createTime']);
            return $admin;
        }
    }

    /** @var User $user */
    public static function addUser($user)
    {
        $stmt = self::$db->prepare("INSERT INTO user(birthDate, sex) "
            . "VALUES(:birthDate,:sex)");
        $stmt->execute(array(
                ':birthDate' => $user->getBirthDate(), ':sex' => $user->getSex())
        );
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1) {
            return TRUE;
        }
        return FALSE;
    }

    public static function getUsers()
    {
        $stmt = self::$db->query('SELECT * FROM user');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function deleteUser($id)
    {
        $stmt = self::$db->prepare('DELETE FROM user WHERE userId=?');
        $stmt->execute(array($id));
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1) {
            return TRUE;
        }
        return FALSE;
    }

    public static function getUserByID($id)
    {
        $stmt = self::$db->prepare('SELECT * FROM user WHERE userId=?');
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = $results[0];
            $user = new User();
            $user->setId($result['userId']);
            $user->setBirthDate($result['birthDate']);
            $user->setSex($result['sex']);
            $user->setCreateDate($result['createDate']);
            return $user;
        }
    }

    /** @var Poll $poll */
    public static function addPoll($poll)
    {
        $stmt = self::$db->prepare("INSERT INTO poll(title) "
            . "VALUES(:title)");
        $stmt->execute(array(':title' => $poll->getTitle()));
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1) {
            return TRUE;
        }
        return FALSE;
    }

    public static function getPollList()
    {
        $stmt = self::$db->query('SELECT * FROM poll');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function deletePoll($id)
    {
        $stmt = self::$db->prepare('DELETE FROM poll WHERE pollId=?');
        $stmt->execute(array($id));
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1) {
            return TRUE;
        }
        return FALSE;
    }

    public static function getPollById($id)
    {
        $stmt = self::$db->prepare('SELECT * FROM poll WHERE pollId=?');
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = $results[0];
            $poll = new Poll();
            $poll->setPollId($result['pollId']);
            $poll->setTitle($result['title']);
            $poll->setCreateDate($result['createDate']);
            return $poll;
        }
    }

    /** @var Poll $poll */
    public static function updatePoll($poll)
    {
        try {
            self::$db->beginTransaction();
            $stmt = self::$db->prepare('UPDATE poll set title=:text'
                . ' WHERE pollId=:pollId');
            $stmt->execute(array(
                ':pollId' => $poll->getPollId(),
                ':text' => $poll->getTitle()
            ));
            $affected_rows = $stmt->rowCount();
            if ($affected_rows == 1) {
                self::$db->commit();
                return TRUE;
            }
        } catch (Exception $ex) {
            self::$db->rollBack();
            return FALSE;
        }
    }

    public static function getPolls()
    {
        $stmt = self::$db->prepare('SELECT * FROM poll');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** @var Question $question */
    public static function addQuestion($question)
    {
        $stmt = self::$db->prepare("INSERT INTO question(pollId, text, allowMultipleAnswers) "
            . "VALUES(:pollId,:text,:allowMultipleAnswers)");
        $stmt->execute(array(
                ':pollId' => $question->getPollId(),
                ':text' => $question->getText(),
                ':allowMultipleAnswers' => $question->getAllowMultipleAnswers())
        );
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1) {
            return TRUE;
        }
        return FALSE;
    }

    /** @var Question $question */
    public static function updateQuestion($question)
    {
        try {
            self::$db->beginTransaction();
            $stmt = self::$db->prepare('UPDATE question set text=:text, allowMultipleAnswers=:allowMultipleAnswers '
                . ' WHERE questionId=:questionId');
            $stmt->execute(array(
                ':questionId' => $question->getQuestionId(),
                ':text' => $question->getText(),
                ':allowMultipleAnswers' => $question->getAllowMultipleAnswers(),
            ));

            $affected_rows = $stmt->rowCount();
            if ($affected_rows == 1) {
                self::$db->commit();
                return TRUE;
            }
        } catch (Exception $ex) {
            echo $ex;
            self::$db->rollBack();
            return FALSE;
        }
    }

    public static function deleteQuestion($id)
    {
        $stmt = self::$db->prepare('DELETE FROM question WHERE questionId=?');
        $stmt->execute(array($id));
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1) {
            return TRUE;
        }
        return FALSE;
    }

    public static function getQuestionById($id)
    {
        $stmt = self::$db->prepare('SELECT * FROM question WHERE questionId=?');
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = $results[0];
            $question = new Question();
            $question->setQuestionId($result['questionId']);
            $question->setPollId($result['pollId']);
            $question->setPoll(self::getPollById($result['pollId']));
            $question->setText($result['text']);
            $question->setAllowMultipleAnswers($result['allowMultipleAnswers']);
            return $question;
        }
    }

    public static function getQuestionsForPoll($pollId)
    {
        $stmt = self::$db->prepare('SELECT * FROM question q WHERE pollId=?');
        $stmt->execute(array($pollId));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getQuestions()
    {
        $stmt = self::$db->prepare('SELECT * FROM question');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //answers
    public static function getAnswers()
    {
        $stmt = self::$db->prepare('SELECT * FROM answer');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAnswersForQuestion($questionId)
    {
        $stmt = self::$db->prepare('SELECT * FROM answer WHERE questionId=?');
        $stmt->execute(array($questionId));
        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    /** @var Answer $answer */
    public static function addAnswer($answer)
    {
        $stmt = self::$db->prepare("INSERT INTO answer(questionId, pollId, text) "
            . "VALUES(:questionId,:pollId,:text)");
        $stmt->execute(array(
                ':questionId' => $answer->getQuestionId(), ':pollId' => $answer->getPollId(), ':text' => $answer->getText())
        );
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1) {
            return TRUE;
        }
        return FALSE;
    }

    public static function deleteAnswer($id)
    {
        $stmt = self::$db->prepare('DELETE FROM answer WHERE answerId=?');
        $stmt->execute(array($id));
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1) {
            return TRUE;
        }
        return FALSE;
    }

    /** @var Answer $answer */
    public static function updateAnswer($answer)
    {
        try {
            self::$db->beginTransaction();
            $stmt = self::$db->prepare('UPDATE answer set text=:text'
                . ' WHERE answerId=:answerId');
            $stmt->execute(array(
                ':answerId' => $answer->getAnswerId(),
                ':text' => $answer->getText(),
            ));

            $affected_rows = $stmt->rowCount();
            if ($affected_rows == 1) {
                self::$db->commit();
                return TRUE;
            }
        } catch (Exception $ex) {
            echo $ex;
            self::$db->rollBack();
            return FALSE;
        }
    }
}

?>