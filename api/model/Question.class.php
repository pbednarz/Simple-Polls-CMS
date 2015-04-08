<?php

class Question implements JsonSerializable
{

    private $questionId;
    private $text;
    private $pollId;
    private $allow_multiple_answers;
    private $poll;

    public function getPoll()
    {
        return $this->poll;
    }

    public function setPoll($poll)
    {
        $this->poll = $poll;
    }

    public function getQuestionId()
    {
        return $this->questionId;
    }

    public function getPollId()
    {
        return $this->pollId;
    }

    public function getAllowMultipleAnswers()
    {
        return $this->allow_multiple_answers;
    }

    public function setAllowMultipleAnswers($allow_multiple_answers)
    {
        $this->allow_multiple_answers = $allow_multiple_answers;
    }

    public function setAllow_Multiple_Answers($allow_multiple_answers)
    {
        $this->setAllowMultipleAnswers($allow_multiple_answers);
    }

    public function setQuestionId($questionId)
    {
        $this->questionId = $questionId;
    }

    public function setPollId($pollId)
    {
        $this->pollId = $pollId;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

?>