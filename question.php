<?php

/**
 * Class question, this class contains the questions of the game, it's choices, points and right answers.
 */
class question
{
    private $question;
    private $choice1;
    private $choice2;
    private $choice3;
    private $answer;
    private $questions_file = "questions.xml";

    // the variable that will hold the xml that contains the questions
    private $xml;

    // these arrays hold the questions that were already chosen to be shown in the game.
    private $chosen_easy_questions = array();
    private $chosen_medium_questions = array();
    private $chosen_hard_questions = array();

    // the question's points
    private $qpoints = 0;

    // the level that the user has currently
    private $current_level = 1;

    /**
     * The constructor is reading the xml that contains the questions.
     * question constructor.
     */
    public function __construct()
    {
        $this->xml = simplexml_load_file($this->questions_file) or die("Error: Cannot create object");
    }

    /**
     * @return the question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @return the first choice
     */
    public function getChoice1()
    {
        return $this->choice1;
    }

    /**
     * @return the second choice
     */
    public function getChoice2()
    {
        return $this->choice2;
    }

    /**
     * @return the third choice
     */
    public function getChoice3()
    {
        return $this->choice3;
    }

    /**
     * @return the answer
     */
    public function getRightChoice()
    {
        return $this->answer;
    }

    /**
     * @return the points of that question
     */
    public function getQPoints()
    {
        return $this->qpoints;
    }

    /**
     * This function sets the arrays that contain the questions that were already shown in the game.
     * @param $chosen_easy_questions
     * @param $chosen_medium_question
     * @param $chosen_hard_questions
     */
    function setChosenQuestions($chosen_easy_questions, $chosen_medium_question, $chosen_hard_questions)
    {
        $this->chosen_easy_questions = $chosen_easy_questions;
        $this->chosen_medium_questions = $chosen_medium_question;
        $this->chosen_hard_questions = $chosen_hard_questions;

    }

    /**
     * This function sets the current level of the user.
     * @param $level
     */
    function setLevel($level)
    {
        $this->current_level = $level;
    }

    /**
     * This function fetches a question depending on which level the user is, and it is responsible to fetch a question
     * that wasn't in the game again.
     * @return int, the random number that picked the question from the xml.
     */
    function fetchQuestions()
    {

        do {
            $flag = 0;
            $random = rand(0, 25);
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

        if ($this->current_level == 0) {
            $this->qpoints = 5;
            array_push($this->chosen_easy_questions, $random);
        } else if ($this->current_level == 1) {
            $this->qpoints = 10;
            array_push($this->chosen_medium_questions, $random);
        } else if ($this->current_level == 2) {
            $this->qpoints = 15;
            array_push($this->chosen_hard_questions, $random);
        }


        $this->question = $this->xml->question_type[$this->current_level]->question[$random]->q;
        $this->choice1 = $this->xml->question_type[$this->current_level]->question[$random]->first_choice;
        $this->choice2 = $this->xml->question_type[$this->current_level]->question[$random]->second_choice;
        $this->choice3 = $this->xml->question_type[$this->current_level]->question[$random]->third_choice;
        $this->answer = $this->xml->question_type[$this->current_level]->question[$random]->right_choice;

        return $random;
    }
}
