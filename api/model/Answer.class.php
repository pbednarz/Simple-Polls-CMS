<?php

class Answer
{
    private $answerId;
    private $questionId;
    private $pollId;
    private $text;

    public function getPollId()
    {
        return $this->pollId;
    }

    public function setPollId($pollId)
    {
        $this->pollId = $pollId;
    }

    public function getAnswerId()
    {
        return $this->answerId;
    }

    public function getQuestionId()
    {
        return $this->questionId;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setAnswerId($answerId)
    {
        $this->answerId = $answerId;
    }

    public function setQuestionId($questionId)
    {
        $this->questionId = $questionId;
    }

    public function setText($text)
    {
        $this->text = $text;
    }
}

?>