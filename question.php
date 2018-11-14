<?php

class question
{
    private $level;
    private $id;
    private $question;
    private $choices;
    private $answer;
    private $points;

    public function __construct($qlevel, $qid, $qquestion, $qchoices, $qanswer, $qpoints)
    {
        $this->level = qlevel;
        $this->id = qid;
        $this->question = qquestion;
        $this->choices = qchoices;
        $this->answer = qanswer;
        $this->points = qpoints;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getQuestion()
    {
        return $this->question;
    }

    public function getChoices()
    {
        return $this->choices;
    }

    public function getAnswer()
    {
        return $this->answer;
    }

    public function getPoints()
    {
        return $this->points;
    }
}

?>