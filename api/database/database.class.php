<?php

Class Database
{

    private static $db;

    public static function getInstance()
    {
        if (!self::$db) {
            self::$db = new PDO('mysql:host=localhost;dbname=polls_cms;charset=utf8', 'root', '');
            return new Database();
        }
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

    /** @var int $id */
    public static function getAdminByID($id)
    {
        $stmt = self::$db->prepare('SELECT * FROM admin WHERE admin_id=?');
        $stmt->execute(array($id));
        if ($stmt->rowCount > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = $results[0];
            $admin = new Admin();
            $admin->setId($result['admin_id']);
            $admin->setUsername($result['username']);
            $admin->setPassword($result['password']);
            $admin->setEmail($result['email']);
            $admin->setCreateTime($result['create_time']);
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
            $admin->setId($result['admin_id']);
            $admin->setUsername($result['username']);
            $admin->setPassword($result['password']);
            $admin->setEmail($result['email']);
            $admin->setCreateTime($result['create_time']);
            return $admin;
        }
    }

    public static function getAdminByUsername($username)
    {
        $stmt = self::$db->prepare('SELECT * FROM admin WHERE username=?');
        $stmt->execute(array($username));
        if ($stmt->rowCount() > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = $results[0];
            $admin = new Admin();
            $admin->setId($result['admin_id']);
            $admin->setUsername($result['username']);
            $admin->setPassword($result['password']);
            $admin->setEmail($result['email']);
            $admin->setCreateTime($result['create_time']);
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
            $admin->setId($result['admin_id']);
            $admin->setUsername($result['username']);
            $admin->setPassword($result['password']);
            $admin->setEmail($result['email']);
            $admin->setCreateTime($result['create_time']);
            return $admin;
        }
    }

    /** @var User $user */
    public static function addUser($user)
    {
        $stmt = self::$db->prepare("INSERT INTO user(birth_date, sex) "
            . "VALUES(:birth_date,:sex)");
        $stmt->execute(array(
                ':birth_date' => $user->getBirthDate(), ':sex' => $user->getSex())
        );
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1) {
            return TRUE;
        }
        return FALSE;
    }

    public static function getUserList()
    {
        $stmt = self::$db->query('SELECT * FROM user');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function deleteUser($id)
    {
        $stmt = self::$db->prepare('DELETE FROM user WHERE user_id=?');
        $stmt->execute(array($id));
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1) {
            return TRUE;
        }
        return FALSE;
    }

    public static function getUserByID($id)
    {
        $stmt = self::$db->prepare('SELECT * FROM user WHERE user_id=?');
        $stmt->execute(array($id));
        if ($stmt->rowCount > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = $results[0];
            $user = new User();
            $user->setId($result['user_id']);
            $user->setBirthDate($result['birth_date']);
            $user->setSex($result['sex']);
            $user->setCreateDate($result['create_date']);
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
        $stmt = self::$db->prepare('DELETE FROM poll WHERE poll_id=?');
        $stmt->execute(array($id));
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1) {
            return TRUE;
        }
        return FALSE;
    }

    public static function getPollById($id)
    {
        $stmt = self::$db->prepare('SELECT * FROM poll WHERE poll_id=?');
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = $results[0];
            $poll = new Poll();
            $poll->setPollId($result['poll_id']);
            $poll->setTitle($result['title']);
            $poll->setCreateDate($result['create_date']);
            return $poll;
        }
    }

    /** @var Poll $poll */
    public static function updatePoll($poll)
    {
        $stmt = self::$db->prepare('UPDATE poll set title=? WHERE poll_id=?');
        $stmt->execute(array($poll->getTitle(), $poll->getPollId()));
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1) {
            return TRUE;
        }
        return FALSE;
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
        $stmt = self::$db->prepare("INSERT INTO question(poll_id, text, allow_multiple_answers) "
            . "VALUES(:poll_id,:text,:allow_multiple_answers)");
        $stmt->execute(array(
                ':poll_id' => $question->getPollId(),
                ':text' => $question->getText(),
                ':allow_multiple_answers' => $question->getAllowMultipleAnswers())
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
            $stmt = self::$db->prepare('UPDATE question set text=:text, allow_multiple_answers=:allow_multiple_answers '
                . ' WHERE question_id=:question_id');
            $stmt->execute(array(
                ':question_id' => $question->getQuestionId(),
                ':text' => $question->getText(),
                ':allow_multiple_answers' => $question->getAllowMultipleAnswers(),
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

    public static function deleteQuestion($poll_id, $id)
    {
        $stmt = self::$db->prepare('DELETE FROM question WHERE question_id=? AND poll_id=?');
        $stmt->execute(array($id, $poll_id));
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1) {
            return TRUE;
        }
        return FALSE;
    }

    public static function getQuestionById($poll_id, $id)
    {
        $stmt = self::$db->prepare('SELECT * FROM question WHERE question_id=? AND poll_id=?');
        $stmt->execute(array($id, $poll_id));
        if ($stmt->rowCount() > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = $results[0];
            $question = new Question();
            $question->setQuestionId($result['question_id']);
            $question->setPollId($result['poll_id']);
            $question->setPoll(self::getPollById($result['poll_id']));
            $question->setText($result['text']);
            $question->setAllowMultipleAnswers($result['allow_multiple_answers']);
            return $question;
        }
    }

    public static function getQuestions($poll_id)
    {
        $stmt = self::$db->prepare('SELECT * FROM question q WHERE poll_id=?');
        $stmt->execute(array($poll_id));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>