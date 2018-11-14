<?php
include 'question.php';

class auxiliary
{

    private $players_file = "players.txt";
    private $questions_file = "questions.xml";

    function fetchQuestions()
    {
        $xml = simplexml_load_file($this->questions_file) or die("Error: Cannot create object");
        echo $xml->question_type[0]->question[0]->q;

        $current_level = 0; // en na ginei 1
        $chosen_easy_questions = array("");
        $chosen_medium_questions = array("");
        $chosen_hard_questions = array("");
        $flag = 0;
        $random = 0;
        $points = 0;

        for ($i = 0; $i < 5; $i++) {

            do {
                $flag = 0;
                $random = rand(0, 9); // prepei na ginei apo 1-25
                if ($current_level == 0)
                    foreach ($chosen_easy_questions as $question)
                        if ($random == $question) $flag = 1;
                if ($current_level == 1)
                    foreach ($chosen_medium_questions as $question)
                        if ($random == $question) $flag = 1;
                if ($current_level == 2)
                    foreach ($chosen_hard_questions as $question)
                        if ($random == $question) $flag = 1;

            } while ($flag);

            if ($current_level == 0)
                array_push($chosen_easy_questions, $random);
            else if ($current_level == 1)
                array_push($chosen_medium_questions, $random);
            else if ($current_level == 2)
                array_push($chosen_hard_questions, $random);

            echo $xml->question_type[$current_level]->question[$random]->q;
            // dame prepei na elegxw ti apanthse gia na allaksw to current_level se easy h hard.
        }


    }

    function savePlayer($player)
    {
        $myfile = fopen($this->players_file, "w") or die("Unable to open file!");
        fwrite($myfile, $player . "\n");
        fclose($myfile);

    }

    function fetchPlayers()
    {
        $players = file_get_contents($this->players_file);

        echo $players;
    }
}
