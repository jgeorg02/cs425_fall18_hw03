<?php

class players
{
    // the file that contains the players
    static $players_file = "players.txt";

    /**
     * This function is responsible for sorting and writing into the file that players and their score and add the new
     * player into that list.
     * @param $player , the new player's nickname.
     * @param $score , the new player's score.
     * @return bool returns true if fwrite was successful, otherwise it returns false.
     */
    static function savePlayer($player, $score)
    {

        $players = players::fetchPlayers();

        if ($players === false) {
            $myfile = fopen(players::$players_file, "w") or die("Unable to open file!");
            $msg = $player . ": " . $score . "\n";
        } else {
            $players_array = explode(PHP_EOL, $players);
            array_push($players_array, $player . ": " . $score);
            usort($players_array, "strnatcmp");

            $myfile = fopen(players::$players_file, "w") or die("Unable to open file!");

            $msg = "";

            for ($i = 0; $i < count($players_array); $i++) {

                if (($players_array[$i] != "") && ($players_array[$i] != "\n"))
                    $msg .= $players_array[$i] . "\n";

            }
        }

        $fwrite = fwrite($myfile, $msg);

        fclose($myfile);
        if ($fwrite === false)
            return false;
        else
            return true;
    }

    /**
     * This function is responsible for returning the contents of the file that has the players and their scores.
     * @return bool|string, returns the players and their scores.
     */
    static function fetchPlayers()
    {
        $players = file_get_contents(players::$players_file);

        return $players;
    }
}
