<?php

class Poll
{

    private $pollId;
    private $title;
    private $createDate;

    public function getPollId()
    {
        return $this->pollId;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setPollId($pollId)
    {
        $this->pollId = $pollId;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getCreateDate()
    {
        return $this->createDate;
    }

    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;
    }


}

?>