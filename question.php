<?php

class question
{
    private $question;
    private $choice1;
    private $choice2;
    private $choice3;
    private $answer;
    private $questions_file = "questions.xml";
    private $xml;
    private $chosen_easy_questions = array();
    private $chosen_medium_questions = array();
    private $chosen_hard_questions = array();
    private $qpoints = 0;
    private $total_points = 0;
    private $current_level = 1;

    public function __construct()
    {
        $this->xml = simplexml_load_file($this->questions_file) or die("Error: Cannot create object");
    }

    public function getQuestion()
    {
        return $this->question;
    }

    public function getChoice1()
    {
        return $this->choice1;
    }


    public function getChoice2()
    {
        return $this->choice2;
    }

    public function getChoice3()
    {
        return $this->choice3;
    }

    public function getRightChoice() {
        return $this->answer;
    }

    public function getTotalPoints()
    {
        return $this->total_points;
    }

    public function getLevel()
    {
        return $this->current_level;
    }

    public function setRightChoice($choice) {
        $this->answer = $choice;
    }

    public function setAnswer($ans)
    {

        if ($ans == $this->answer) {
            $this->total_points += $this->qpoints;
            switch ($this->current_level) {
                case 0:
                    $this->current_level = 1;
                    break;
                case 1:
                    $this->current_level = 2;
                    break;
            }
        } else
            switch ($this->current_level) {
                case 1:
                    $this->current_level = 0;
                    break;
                case 2:
                    $this->current_level = 1;
                    break;
            }

        return  'given : ' . $ans . ' ans: ' . $this->answer;
    }

    function setChosenQuestions($chosen_easy_questions, $chosen_medium_question, $chosen_hard_questions)
    {
        $this->chosen_easy_questions = $chosen_easy_questions;
        $this->chosen_medium_questions = $chosen_medium_question;
        $this->chosen_hard_questions = $chosen_hard_questions;

    }

    function setLevelPoints($level, $points)
    {
        $this->current_level = $level;
        $this->total_points = $points;
    }

    function fetchQuestions()
    {

        do {
            $flag = 0;
            $random = rand(0, 9); // prepei na ginei apo 1-25
            if ($this->current_level == 0)
                foreach ($this->chosen_easy_questions as $question)
                    if ($random == $question) $flag = 1;
            if ($this->current_level == 1)
                foreach ($this->chosen_medium_questions as $question)
                    if ($random == $question) $flag = 1;
            if ($this->current_level == 2)
                foreach ($this->chosen_hard_questions as $question)
                    if ($random == $question) $flag = 1;

        } while ($flag);

        if ($this->current_level == 0) $this->qpoints = 5;
        else if ($this->current_level == 1)
            $this->qpoints = 10;
        else if ($this->current_level == 2)
            $this->qpoints = 15;


        $this->question = $this->xml->question_type[$this->current_level]->question[$random]->q;
        $this->choice1 = $this->xml->question_type[$this->current_level]->question[$random]->first_choice;
        $this->choice2 = $this->xml->question_type[$this->current_level]->question[$random]->second_choice;
        $this->choice3 = $this->xml->question_type[$this->current_level]->question[$random]->third_choice;
        $this->answer = $this->xml->question_type[$this->current_level]->question[$random]->right_choice;

        return $random;
    }
}
