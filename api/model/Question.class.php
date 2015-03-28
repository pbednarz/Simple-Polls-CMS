<?php

class Question
{

    private $questionId;
    private $nazwa;
    private $pollId;
    private $allowMultipleAnswers;
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

    public function getNazwa()
    {
        return $this->nazwa;
    }

    public function getIdMarki()
    {
        return $this->idMarki;
    }

    public function getPollId()
    {
        return $this->pollId;
    }

    public function getAllowMultipleAnswers()
    {
        return $this->allowMultipleAnswers;
    }

    public function setQuestionId($questionId)
    {
        $this->questionId = $questionId;
    }

    public function setNazwa($nazwa)
    {
        $this->nazwa = $nazwa;
    }

    public function setPollId($pollId)
    {
        $this->pollId = $pollId;
    }

    public function setAllowMultipleAnswers($allowMultipleAnswers)
    {
        $this->allowMultipleAnswers = $allowMultipleAnswers;
    }
}

?>