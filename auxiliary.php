<?php

class auxiliary
{

    private $players_file = "players.txt";

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
