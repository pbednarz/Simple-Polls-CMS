<?php

class Poll implements JsonSerializable
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