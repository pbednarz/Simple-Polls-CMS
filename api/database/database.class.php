<?php

Class Database {

    private static $db;

    public static function getInstance() {
        if (!self::$db) {
            self::$db = new PDO('mysql:host=localhost;dbname=polls_cms;charset=utf8', 'root', '');
            return new Database();
        }
    }

    public static function getQuestionById($id) {
        $stmt = self::$db->prepare('SELECT * FROM question WHERE question_id=?');
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = $results[0];
            $question = new Question();
            $question->setQuestionId($result['question_id']);
            $question->setPollId($result['poll_id']);
            $question->setPoll(self::getPollById($result['poll_id']));
            $question->setNazwa($result['question_text']);
            $question->setAllowMultipleAnswers($result['allow_multiple_answers']);
            return $question;
        }
    }

    public static function getPollById($id) {
        $stmt = self::$db->prepare('SELECT * FROM poll p WHERE poll_id=?');
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = $results[0];
            $poll = new Poll();
            $poll->setPollId($result['poll_id']);
            $poll->setTitle($result['poll_title']);
            $poll->setCreateDate($result['create_date']);
            return $poll;
        }
    }

    public static function getQuestions($id) {
        $stmt = self::$db->prepare('SELECT * FROM question q WHERE poll_id=?');
        $stmt->execute(array($id));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getPolls() {
        $stmt = self::$db->execute('SELECT * FROM poll');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>