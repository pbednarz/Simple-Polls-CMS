<?php

class UserAnswer
{
    private $userId;
    private $answerId;

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getAnswerId()
    {
        return $this->answerId;
    }

    public function setAnswerId($answerId)
    {
        $this->answerId = $answerId;
    }


}
